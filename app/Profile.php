<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //
    protected $fillable = [
        'nom', 'prénom', 'adresse', 'tel', 'email', 'photo','mot de passe'
    ];
}
