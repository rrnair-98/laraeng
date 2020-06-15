<?php


namespace App\Features\Marketplace\Models;


use App\Helpers\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;
    use Uuid;


    public function cartCourses(){
        return $this->hasMany("App\Features\Marketplace\Models\CartCourse");
    }
}
