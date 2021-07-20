<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alergias extends Model
{
    protected $table = 'alergias';
    protected $primaryKey = 'id_alergia';

            /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "medicamento", "paciente", "descrip"
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

    public function medicamentos()
    {
        return $this->belongsTo('App\Models\Medicamentos', 'medicamento');
    }
}
