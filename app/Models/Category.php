<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug'
    ];

    protected static function booted()
    {
        self::creating(function ($model) {
            $model->slug = Str::slug($model['name']);
        });
    }

    /* SECTION RELACIONES */

    public function vehicles () {
        return $this->hasMany(Vehicle::class);
    }

    /* !SECTION RELACIONES */
}
