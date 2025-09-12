<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleCharacteristicElement extends Model
{
    protected $table = "vehicle_characteristic_element";
    protected $fillable = ['vehicle_characteristic_id', 'title', 'text', 'image', 'position'];

    public function getFullSrc () {
        return config('app.url') . '/storage/' . $this->image;
    }

    /* SECTION RELACIONES */

    public function vehicle () {
        return $this->belongsTo(Vehicle::class);
    }
    public function characteristic () {
        return $this->belongsTo(VehicleCharacteristic::class);
    }

    /* !SECTION RELACIONES */
}
