<?php


namespace App\Helpers;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class BaseQuery
{
    private $fullyQualifiedModel;
    public function __construct(string $fullyQualifiedModel)
    {
        $this->fullyQualifiedModel = $fullyQualifiedModel;
    }

    /**
     * Fetches a single row based upon the value of the
     * @param $column The column to query
     * @param $value The value to query the column with
     * @throws ModelNotFoundException When the provided column doesnt hold the value given
     * @return mixed
     */
    public function fetchOneByCol($column, $value){
        return $this->fullyQualifiedModel::where($column, '=', $value)->firstOrFail();
    }

    /**
     * Paginates the current model. Assumes limit to be 15 by default and offset to be 0.
     * Sample output format:
     * [
     *  "data"=>[array],
     *  "remaining_entries"=>integer
     * ]
     * Sample usage:
     * - when being used in a base query
     *      parent::paginate(10,0);
     *      parent::paginate(10, 0, [["user_id", 1]]);
     * - when being used from a base query
     *      query->paginate(10,0);
     *      query->paginate(10,0,[["user_id", 1]]);
     *
     * @param int $limit The number of records to fetch. Maximum of 15
     * @param int $offset The number of records to skip.
     * @param array|null $whereArray The array of where conditions
     * @param array|null $withArray The array of relations to join and fetch with this collection
     * @return array
     */
    public function paginate($limit = 15, $offset = 0, $whereArray=null, $withArray=null){
        $limit = $limit & 0xf;

        $query = $withArray == null? $this->fullyQualifiedModel::skip($offset)->take($limit):
            $this->fullyQualifiedModel::with($withArray)->skip($offset)->take($limit);

        $numPagesQuery = $this->fullyQualifiedModel::select(DB::raw("count(id) as num"));
        if($whereArray != null){
            $query = $this->fullyQualifiedModel::where($whereArray)->skip($offset)->take($limit);
            $query = $withArray == null ? $query : $query->with($withArray);
            $numPagesQuery =  $this->fullyQualifiedModel::where($whereArray)->select(DB::raw("count(id) as num"));
        }
        $collection = $query->get();
        $numPages = $numPagesQuery->first();
        $readEntries = $limit+$offset;
        $numPages = $numPages->num > $readEntries ? $numPages->num - ($readEntries): 0;

        return ["data" => $collection, "remaining_entries" => $numPages];
    }


    /**
     * Fetches a model instance with id and the specified relations.
     * Sample Usage:
     *  $query->fetchByIdWith(1, ['hello']);
     * @param $id ID id of the model to be fetched
     * @param array $with The array of relations to join
     * @return mixed
     */
    public function fetchByIdWith($id, array $with){
        return $this->fullyQualifiedModel::where('id', $id)->with($with)->firstOrFail();
    }

}
