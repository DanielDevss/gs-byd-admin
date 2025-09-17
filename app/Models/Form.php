<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = [
        'key',
        'label'
    ];

    public function emails()
    {
        return $this->belongsToMany(Email::class, 'emails_has_forms');
    }
}
