<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicoEspecialidad extends Model
{
    protected $table = 'medico_especialidad';
    protected $primaryKey = 'id_medico_especialidad';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "especialidad", "medico"
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function medicos()
    {
        return $this->belongsTo('App\Models\Personas', 'medico');
    }

    public function especialidades()
    {
        return $this->belongsTo('App\Models\Especialidades', 'especialidad');
    }
}
