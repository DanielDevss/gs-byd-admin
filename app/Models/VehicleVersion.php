<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleVersion extends Model
{
    protected $fillable = ['name', 'price'];

    public function getPriceFormat()
    {
        return '$' . number_format($this->price, 0, '.', ',');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

}
