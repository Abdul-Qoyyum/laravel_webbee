<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function workshops(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Workshop::class,"event_id");
    }
}
