<?php

namespace App\Features\Courses\Models;

use App\Helpers\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    //
    use SoftDeletes;
    use Uuid;
    public $timestamps = true;
    public $casts = ['units'=>'array'];
    protected $guarded = [];
    protected $table = 'courses';

    public static function getCreateValidationRules() {
        return [
            'valid_till'    => 'required',
            'name'          => 'required|max:255|unique:courses',
            'price'         => 'required|numeric|min:1',
            'file_urls'     => 'sometimes|array',
            'description'   => 'sometimes|required',
            'created_by'    => 'required|exists:users,id',
        ];
    }

    public static function getUpdateValidationRules() {
        return [
            'valid_till'    => 'required|date_format:Y-m-d H:i:s',
            'name'          => 'required|max:255|unique:courses',
            'price'         => 'required|numeric|min:1',
            'file_urls'     => 'required|array',
            'description'   => 'sometimes|required',
            'updated_by'    => 'exists:users,id',
            'deleted_at'    => 'required|date_format:Y-m-d H:i:s',
        ];
    }

    public function isOwner(string $userId) : bool {
        return $this->created_by === $userId;
    }
}
