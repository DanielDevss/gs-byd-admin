<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleSetting extends Model
{
    protected $fillable = ['vehicle_id', 'name', 'section', 'preview', 'icon', 'text'];

    public function getFullSrc () {
        return config('app.url') . '/storage/' . $this->preview;
    }

    /* SECTION RELACIONES */

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

}
