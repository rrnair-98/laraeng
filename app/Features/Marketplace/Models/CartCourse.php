<?php


namespace App\Features\Marketplace\Models;


use App\Helpers\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartCourse extends Model
{
    use SoftDeletes;
    use Uuid;
}
