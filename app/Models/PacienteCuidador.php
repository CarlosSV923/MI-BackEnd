<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PacienteCuidador extends Model
{
    protected $table = 'paciente_cuidador';
    protected $primaryKey = 'id_paciente_cuidador';

            /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "cuidador", "paciente"
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

    public function cuidadores()
    {
        return $this->belongsTo('App\Models\Personas', 'cuidador');
    }
}
