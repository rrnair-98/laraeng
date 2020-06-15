<?php


namespace App\Features\Courses\Transactors;


use App\Features\Courses\Queries\CourseQuery;
use App\Features\Courses\Transactors\Mutators\CourseMutator;
use App\Helpers\BaseTransactor;

class CourseTransactor extends BaseTransactor
{
    public function __construct(CourseQuery $query, CourseMutator $mutator)
    {
        parent::__construct($query, $mutator, 'id');
    }
}
