<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
    protected $table = 'citas';
    protected $primaryKey = 'id_cita';

                        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fecha_agendada', "fecha_atencion", "estado", "paciente", "medico","seguimiento", "observRec", "planTratam", "procedimiento", "instrucciones", "sintomas"
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

    public function medicos()
    {
        return $this->belongsTo('App\Models\Personas', 'medico');
    }

    public function seguimientos()
    {
        return $this->belongsTo('App\Models\Seguimientos', 'seguimiento');
    }

    public function enfermedades_citas()
    {
        return $this->hasMany('App\Models\EnfermedadesCitas', 'cita');
    }

    public function examenes()
    {
        return $this->hasMany('App\Models\Examenes', 'cita');
    }

    public function info_medica()
    {
        return $this->hasMany('App\Models\InfoMedica', 'cita');
    }

    public function medicamentos_citas()
    {
        return $this->hasMany('App\Models\MedicamentosCitas', 'cita');
    }

    public function cuidador_cita()
    {
        return $this->hasMany('App\Models\CuidadorCita', 'cita');
    }
}
