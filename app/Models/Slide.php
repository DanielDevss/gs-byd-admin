<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $fillable = ['name', 'src', 'alt', 'url', 'section', 'programmable', 'status', 'published_at', 'finished_at'];

    protected $casts = [
        'programmable'  => 'bool',
        'published_at'  => 'datetime',
        'finished_at'   => 'datetime',
    ];

    public function getFullSrc() {
        return config('app.url') . '/storage/' . $this->src;
    }

    protected static function booted(): void
    {
        static::creating(function (Slide $slide) {
            $slide->published_at ??= now();
        });
    }

    public function webs () {
        return $this->belongsToMany(Web::class, 'webs_slides');
    }

}
