<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Slide extends Model
{
    protected $fillable = ['position', 'name', 'src', 'alt', 'url', 'section', 'programmable', 'status', 'published_at', 'finished_at'];

    protected $casts = [
        'programmable' => 'bool',
        'published_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function scopeAvailable(Builder $query, null|string|\DateTimeInterface $moment = null): Builder
    {
        $now = $moment ? Carbon::parse($moment) : now();

        return $query
            ->where(function (Builder $q) use ($now) {
                $q->whereNull('published_at')      // sin inicio => disponible
                    ->orWhere('published_at', '<=', $now);
            })
            ->where(function (Builder $q) use ($now) {
                $q->whereNull('finished_at')       // sin fin => sigue disponible
                    ->orWhere('finished_at', '>=', $now);
            });
    }

    public function getFullSrc()
    {
        return config('app.url') . '/storage/' . $this->src;
    }

    protected static function booted(): void
    {
        static::creating(function (Slide $slide) {
            $slide->published_at ??= now();
        });
    }

    public function webs()
    {
        return $this->belongsToMany(Web::class, 'webs_slides');
    }

}
