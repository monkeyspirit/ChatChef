<?php

namespace App;



use Illuminate\Database\Eloquent\Model;

class webUser extends Model
{
    protected $table = 'user';
    public $timestamps = false;

    protected $fillable = ['username','firstname', 'lastname', 'email', 'password','birthday','favorites'];

}
