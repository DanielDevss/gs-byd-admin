<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Vehicle extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'slug_byd',
        'cover',
        'banner',
        'banner_attributes',
        'year',
        'technical_sheet',
    ];

    protected static function booted()
    {
        self::creating(function ($model) {
            $model->slug = Str::slug($model['name']);
        });
    }

    public function getCoverLink()
    {
        return config('app.url') . '/storage/' . $this->cover;
    }

    public function getBannerLink()
    {
        return config('app.url') . '/storage/' . $this->banner;
    }

    public function getBannerAttrLink()
    {
        return config('app.url') . '/storage/' . $this->banner_attributes;
    }

    public function getBestPrice()
    {
        $version = $this->versions()->orderBy('price')->first();
        return $version ? $version->getPriceFormat() : "No definido";
    }

    /**
     * SECTION RELACIONES
     */

    public function versions()
    {
        return $this->hasMany(VehicleVersion::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function settings()
    {
        return $this->hasMany(VehicleSetting::class);
    }

    public function attributes()
    {
        return $this->hasMany(VehicleAttribute::class);
    }

    public function characteristics()
    {
        return $this->hasMany(VehicleCharacteristic::class);
    }

    public function pictures()
    {
        return $this->hasMany(VehiclePicture::class);
    }

    /* !SECTION RELACIONES */
}
