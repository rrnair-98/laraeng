<?php


namespace App\Features\Courses\Queries;


use App\Helpers\BaseQuery;

class CourseQuery extends BaseQuery
{
    public function __construct()
    {
        parent::__construct('App\Features\Courses\Models\Course');
    }
}
