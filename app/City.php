<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    protected $fillable = [
        'id', 'city_name',
    ];
    public function plans()
    {
        return $this->belongsToMany(Plan::class);
    }
}
