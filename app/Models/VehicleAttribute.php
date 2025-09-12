<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleAttribute extends Model
{
    protected $fillable = ['vehicle_id', 'title', 'description', 'position'];

    /* SECTION RELACIONES */

    public function vehicle () {
        return $this->belongsTo(Vehicle::class);
    }

    /* !SECTION RELACIONES */
}
