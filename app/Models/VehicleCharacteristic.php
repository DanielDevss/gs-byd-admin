<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleCharacteristic extends Model
{
    protected $fillable = ['vehicle_id', 'title', 'text', 'position'];

    /* SECTION RELACIONES */

    public function vehicle () {
        return $this->belongsTo(Vehicle::class);
    }

    public function elements () {
        return $this->hasMany(VehicleCharacteristicElement::class);
    }

    /* !SECTION RELACIONES */
}
