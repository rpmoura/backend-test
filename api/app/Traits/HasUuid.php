<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid as RamseyUuid;

trait HasUuid
{
    public static function bootHasUuid()
    {
        static::creating(function ($model) {
            $model->uuid = RamseyUuid::uuid4()->toString();
        });
    }
}
