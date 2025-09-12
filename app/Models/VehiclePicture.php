<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehiclePicture extends Model
{
    protected $fillable = ['vehicle_id', 'src', 'alt'];

    public function vehicle () {
        return $this->belongsTo(Vehicle::class);
    }

    public function getFullSrc () {
        return config('app.url') . '/storage/' . $this->src;
    }
}
