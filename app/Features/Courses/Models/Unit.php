<?php


namespace App\Features\Courses\Models;


use App\Helpers\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use SoftDeletes;
    use Uuid;
}
