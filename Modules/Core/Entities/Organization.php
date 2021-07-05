<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
