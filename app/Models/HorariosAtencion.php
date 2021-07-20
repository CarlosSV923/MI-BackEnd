<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorariosAtencion extends Model
{
    protected $table = 'horarios_atencion';
    protected $primaryKey = 'id_horario_atencion';

                    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dias_atencion', "horario_atencion", "medico"
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
}
