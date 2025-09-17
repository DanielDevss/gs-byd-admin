<?php

namespace App\Models;

use App\Enum\SentType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = [
        'email',
        'name'
    ];

    public function forms()
    {
        return $this->belongsToMany(Form::class, 'emails_has_forms')
            ->withPivot(['type']);
    }

    public function webs()
    {
        return $this->belongsToMany(Web::class, 'emails_has_webs');
    }

    public function scopeGetAvailableWebForm(Builder $query, string $appkey, string $formkey, SentType $type = SentType::TO)
    {
        return $query
            ->whereHas('webs', fn($q) => $q->where('app_key', $appkey))
            ->whereHas('forms', fn($q) => $q->where('key', $formkey)->where('type', $type->value));
    }

}
