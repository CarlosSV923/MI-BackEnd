<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnfermedadesHereditarias extends Model
{
    protected $table = 'enfermedades_hereditarias';
    protected $primaryKey = 'id_enfermedad_hereditaria';

                /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "enfermedad", "paciente", "descrip"
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function pacientes()
    {
        return $this->belongsTo('App\Models\Personas', 'paciente');
    }

    public function enfermedades()
    {
        return $this->belongsTo('App\Models\Enfermedades', 'enfermedad');
    }
}
