<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscapacidadPaciente extends Model
{
    protected $table = 'discapacidad_paciente';
    protected $primaryKey = 'id_discapacidad_paciente';

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "discapacidad", "paciente"
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

    public function discapacidades()
    {
        return $this->belongsTo('App\Models\Discapacidades', 'discapacidad');
    }
}
