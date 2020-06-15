<?php


namespace App\Transactors\Mutations;


use App\Helpers\ArrayHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


/**
 * Base class for all mutators. Performs create update and delete for all models.
 * All models must have public constants getCreateValidationRules and getUpdateValidationRules for this to work as expected
 * If you wish to implement custom logic for update remember to keep the keys optional. Since this calls update to delete
 * an instance. For more information on having optional keys read this class's update method.
 * Class BaseMutator
 * @package App\Transactors\Mutations
 */
abstract class BaseMutator
{

    private $fullyQualifiedModel;
    private $column;

    protected const TIMESTAMP_FORMAT = 'Y-m-d H:i:s';

    /**
     * BaseMutator constructor.
     * @param string $fullyQualifiedModel The name of the model. Must be fully qualified.
     * @param string $column The name of the column in the model to update this instance with.
     */
    public function __construct($fullyQualifiedModel, string $column)
    {
        $this->fullyQualifiedModel = $fullyQualifiedModel;
        $this->column = $column;
    }

    /**
     * Persists an instance
     * @param array $args The data to persist in the model.
     * @return mixed The model instance that got created.
     * @throws \Throwable
     */
    public function create(array $args) {
        $validArgs = ArrayHelper::mergePrimaryKeysAndValues($this->fullyQualifiedModel::getCreateValidationRules(), $args);
        $validator = Validator::make($validArgs, $this->fullyQualifiedModel::getCreateValidationRules());
        error_log(json_encode($validator->errors()->getMessages()));
        throw_if($validator->fails(),  ValidationException::withMessages($validator->errors()->getMessages()));
        return $this->fullyQualifiedModel::create($validArgs)->fresh();
    }

    /**
     * Updates an instance.
     * @param int $modelId The id of the model to be updated.
     * @param array $args An array of arguments
     * @param $otherColumn If you want to mass update, set other column to some value
     * @param $customValidationRules array Pass this in if you want to add custom validation rules.
     * DO NOTE- Keys persisted in the database are fetched from model::getUpdateValidationRules array.
     * So this must be a subset of model::getUpdateValidationRules.
     * @return integer Returns 1 if the data is updated, 0 otherwise
     * @throws  ValidationException If data is invalid
     * @throws \Throwable
     */
    public function update($modelId, array $args, $otherColumn = null, array $customValidationRules = null) {
        $currentValidationRulesArray = $customValidationRules ? ArrayHelper::mergePrimaryKeysAndValues($this->fullyQualifiedModel::getUpdateValidationRules,
            $customValidationRules) : $this->fullyQualifiedModel::getUpdateValidationRules;
        $validArgs = ArrayHelper::mergePrimaryKeysAndValues($currentValidationRulesArray, $args);
        if(array_key_exists('updated_by', $validArgs)){
            $optionalValidationKeys = ArrayHelper::mergePrimaryKeysAndValues($validArgs, $currentValidationRulesArray);
            $validator = Validator::make($validArgs, $optionalValidationKeys);
            throw_if($validator->fails(),  ValidationException::withMessages($validator->errors()->getMessages()));
            return $this->fullyQualifiedModel::where($otherColumn == null ? $this->column: $otherColumn, '=', $modelId)->firstOrFail()->update($validator->validated());
        }
        throw  new \ErrorException(json_encode(['updated_by' => 'Updated by not given']));

    }

    /**
     * Deletes an instance.
     * @param $modelId
     * @param $deletedBy
     * @param null $otherColumn
     * @return int
     * @throws ValidationException
     * @throws \Throwable
     */
    public function delete($modelId, $deletedBy, $otherColumn = null) {
        return $this->update($modelId, ['deleted_at' => Carbon::now()->format(self::TIMESTAMP_FORMAT),
            'updated_by' => $deletedBy], $otherColumn);
    }

    /**
     * Searches the specified model with the given key by using whereIn, with the args that were provided.
     * If the value in $column is null the default discriminator is used.
     * @param $columnInFields array The array to perform IN query with
     * @param $args array The array of arguments to update data with.
     * @param $column string The name of the column to use in the IN query
     * @return integer The number of rows updated
     * @throws  ValidationException If data is invalid
     * @throws \Throwable
     */
    public function updateBulk($columnInFields, array $args, $column=null) {
        $validArgs = ArrayHelper::mergePrimaryKeysAndValues($this->fullyQualifiedModel::getUpdateValidationRules(), $args);
        if (array_key_exists('updated_by', $validArgs)) {
            $optionalValidationKeys = ArrayHelper::mergePrimaryKeysAndValues($validArgs, $this->fullyQualifiedModel::getUpdateValidationRules());
            $validator = Validator::make($validArgs, $optionalValidationKeys);
            throw_if($validator->fails(), ValidationException::withMessages($validator->errors()->getMessages()));
            $column = $column == null? $this->column: $column;
            $args['updated_at'] = Carbon::now()->format(self::TIMESTAMP_FORMAT);
            return $this->fullyQualifiedModel::whereIn($column, $columnInFields)->update($args);
        }
    }

    /**
     * Mass deletes the current model with the given modelIds. If otherColumn is null the default discriminator is used.
     * @param $modelIds array
     * @param $deletedBy ID
     * @param null $otherColumn
     * @return int
     * @throws ValidationException
     * @throws \Throwable
     */
    public function bulkDelete($modelIds, $deletedBy, $otherColumn=null) {
        return $this->updateBulk($modelIds, ['deleted_at' => Carbon::now()->format(self::TIMESTAMP_FORMAT),
            'updated_by' => $deletedBy], $otherColumn == null? $this->column: $otherColumn);
    }


}
