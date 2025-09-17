<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Web extends Model
{
    protected $fillable = ['web', 'app_key'];

    public function slides()
    {
        return $this->belongsToMany(Slide::class, 'webs_slides');
    }

    public function emails()
    {
        return $this->belongsToMany(Email::class, 'emails_has_webs');
    }
}
