<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicamentosCitas extends Model
{
    protected $table = 'medicamentos_citas';
    protected $primaryKey = 'id_medicamento_cita';

                    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "duracion", "frecuencia", "dosis", "medicamento", "cita"
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function medicamentos()
    {
        return $this->belongsTo('App\Models\Medicamentos', 'medicamento');
    }

    public function citas()
    {
        return $this->belongsTo('App\Models\Citas', 'cita');
    }
}

