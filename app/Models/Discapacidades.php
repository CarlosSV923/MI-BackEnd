<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discapacidades extends Model
{
    protected $table = 'discapacidades';
    protected $primaryKey = 'id_discapacidad';

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

    public function discapacidad_paciente()
    {
        return $this->hasMany('App\Models\DiscapacidadPaciente', 'discapacidad');
    }
}
