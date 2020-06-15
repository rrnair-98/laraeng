<?php


namespace App\Features\Submissions\Models;


use App\Helpers\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submission extends Model
{
    use SoftDeletes;
    use Uuid;
}
