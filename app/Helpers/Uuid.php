<?php


namespace App\Helpers;


use Illuminate\Support\Str;

trait Uuid
{
    protected static function bootUuid() {
        static::creating(function($model) {
            $model->id = \Ramsey\Uuid\Uuid::uuid4()->toString();
        });

        static::saving(function ($model) {
            // for cases when someone try's to change the uuid manually
            $original_uuid = $model->getOriginal('id');

            if ($original_uuid !== $model->id) {
                $model->id = $original_uuid;
            }
        });
    }

    public function getIncrementing() {
        return false;
    }

    public function getKeyType() {
        return 'string';
    }
}
