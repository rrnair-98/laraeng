<?php


namespace App\Features\Courses\Transactors\Mutators;


use App\Transactors\Mutations\BaseMutator;

class CourseMutator extends BaseMutator
{
    public function __construct()
    {
        parent::__construct('App\Features\Courses\Models\Course', 'id');
    }
}
