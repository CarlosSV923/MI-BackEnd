<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'username';

            /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'estado', "password", "cedula", "rol", "username"
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    	'created_at', 'updated_at'
    ];

    public function roles()
    {
        return $this->belongsTo('App\Models\Roles', 'rol');
    }

    public function personas()
    {
        return $this->belongsTo('App\Models\Personas', 'cedula');
    }
}
