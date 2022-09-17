<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany($this, "parent_id");
    }
}
