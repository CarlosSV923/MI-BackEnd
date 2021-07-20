<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enfermedades extends Model
{
    protected $table = 'enfermedades';
    protected $primaryKey = 'id_enfermedad';

                    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', "descrip", "codigo"
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    	'created_at', 'updated_at'
    ];

    public function enfermedades_hereditarias()
    {
        return $this->hasMany('App\Models\EnfermedadesHereditarias', 'enfermedad');
    }

    public function enfermedades_persistentes()
    {
        return $this->hasMany('App\Models\EnfermedadesPersistentes', 'enfermedad');
    }

    public function enfermedades_seguimientos()
    {
        return $this->hasMany('App\Models\EnfermedadesSeguimientos', 'enfermedad');
    }

    public function enfermedades_citas()
    {
        return $this->hasMany('App\Models\EnfermedadesCitas', 'enfermedad');
    }
}
