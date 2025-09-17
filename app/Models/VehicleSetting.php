<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleSetting extends Model
{
    protected $fillable = ['vehicle_id', 'name', 'section', 'preview', 'icon', 'text'];

    public function getFullSrc()
    {
        return config('app.url') . '/storage/' . $this->preview;
    }

    public function getBgIcon()
    {
        $base_path = config('app.url') . '/storage/';
        return $this->section === 'Rines'
            ? ['backgroundImage' => "url('$base_path{$this->icon}')"]
            : ['background' => $this->icon];
    }

    /* SECTION RELACIONES */

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

}
