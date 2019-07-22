<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    //
    protected $fillable = [
        'name'
    ];
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
