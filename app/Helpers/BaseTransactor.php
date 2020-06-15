<?php


namespace App\Helpers;


use App\Transactors\Mutations\BaseMutator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

abstract class BaseTransactor
{

    private const UNDEFINED_BULK_DELETE = "bulkDeleteColumn is undefined";

    /**
     * @var BaseMutator The mutator of this model. MUST be set by the class that inherits this
     */
    protected $mutator;

    /**
     * @var BaseQuery The query of this model. MUST be set by the class that inherits this
     */
    protected $query;

    /**
     * @var string The name of this transactor. MUST be set by the class that inherits this
     */
    protected $className;

    /**
     * @var string The column you would use to perform bulk delete
     */
    protected $bulkDeleteColumn;

    public function __construct(BaseQuery $query, BaseMutator $mutator, $bulkDeleteColumn)
    {
        $this->query = $query;
        $this->mutator = $mutator;
        $this->bulkDeleteColumn = $bulkDeleteColumn;
    }

    /**
     * Persists and returns a instance.
     * @param array $args Arguments to persist
     * @param $createdById ID Id of the user who initiated this request
     * @param $extraArgs array Pass in the CustomerId of the user
     * @return mixed
     * @throws ValidationException
     * @throws \Throwable
     */
    public function create($createdById, array $args, array $extraArgs = null){
        try{
            DB::beginTransaction();
            $args['created_by'] = $createdById;
            $address = $this->mutator->create($args);
            DB::commit();
            return $address;
        } catch (ValidationException $exception){
            DB::rollBack();
            Log::error("Exception at $this->className:create", ["trace"=>$exception->getTrace()
                , "message" => $exception->errors()
            ]);
            throw $exception;
        } catch (\Exception $exception){
            DB::rollBack();
            Log::error("Exception at $this->className:create", ["trace"=>$exception->getTrace()
                , "message" => $exception->getMessage()
            ]);
            throw $exception;
        }
    }

    /**
     * Updates an instance.
     * Sample usage
     * $transactor->update(1, ['customer_address_fullname'=>'hello'], 1);
     * @param $modelId ID The id of the model to update
     * @param array $args Arguments to update with
     * @param $updatedById ID The id of the user who initiated this request
     * @param array $extraArgs Unused
     * @return int Number of rows updated
     * @throws ValidationException
     * @throws \Throwable
     */
    public function update($modelId, $updatedById, array $args, array $extraArgs = null){
        try{
            DB::beginTransaction();
            $args['updated_by'] = $updatedById;
            $numRowsUpdated = $this->mutator->update($modelId, $args);
            DB::commit();
            return $numRowsUpdated;
        } catch (ValidationException $exception){
            DB::rollBack();
            throw $exception;
        } catch (\Exception $exception){
            DB::rollBack();
            Log::error("Exception at $this->className:update", ["trace"=>$exception->getTrace()
                , "message" => $exception->getMessage()
            ]);
            throw $exception;
        }
    }

    /**
     * Deletes an instance.
     * Sample usage:
     * $transactor->delete(1, 2);
     * @param $modelId ID The id of the row to delete
     * @param $deletedById ID The id of the user who initiated this request
     * @param array $extraArgs Unused
     * @return integer
     * @throws ValidationException If there are invalid arguments
     * @throws \Throwable
     */
    public function delete($modelId, $deletedById, array $extraArgs = null){
        try{
            DB::beginTransaction();
            $numRows = $this->mutator->delete($modelId, $deletedById);
            DB::commit();
            return $numRows;
        } catch (ValidationException $exception){
            DB::rollBack();
            throw $exception;
        } catch (\Exception $exception){
            DB::rollBack();
            Log::error("Exception at $this->className:delete", ["trace"=>$exception->getTrace()
                , "message" => $exception->getMessage()
            ]);
            throw $exception;
        }
    }

    /**
     * @param array $modelIds The ids to use in 'in' query
     * @param $deletedById ID The id of the user who initiated this request
     * @return int
     * @throws ValidationException
     * @throws \ErrorException
     * @throws \Throwable
     */
    public function bulkDelete(array $modelIds, $deletedById){
        try{
            throw_if($this->bulkDeleteColumn === null, \ErrorException::class, self::UNDEFINED_BULK_DELETE);
            DB::beginTransaction();
            $numRows = $this->mutator->bulkDelete($modelIds, $deletedById, $this->bulkDeleteColumn);
            DB::commit();
            return $numRows;
        } catch (ValidationException|\ErrorException $exception){
            DB::rollBack();
            throw $exception;
        } catch (\Exception $exception){
            DB::rollBack();
            Log::error("Exception at $this->className:bulkDelete", ["trace"=>$exception->getTrace()
                , "message" => $exception->getMessage()
            ]);
        }
    }


}
