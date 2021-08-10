<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examenes extends Model
{
    protected $table = 'examenes';
    protected $primaryKey = 'id_examen';

                     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url_examen', "seguimiento", "diagnostico","tipo_examen", "medico", "paciente", "comentarios", 'created_at',"cita"
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    	 'updated_at'
    ];

    public function citas()
    {
        return $this->belongsTo('App\Models\Citas', 'cita');
    }

    public function seguimientos()
    {
        return $this->belongsTo('App\Models\Seguimientos', 'seguimiento');
    }

    public function pacientes()
    {
        return $this->belongsTo('App\Models\Personas', 'paciente');
    }

    public function medicos()
    {
        return $this->belongsTo('App\Models\Personas', 'medico');
    }


}
