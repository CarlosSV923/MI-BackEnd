<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicamentos extends Model
{
    protected $table = 'medicamentos';
    protected $primaryKey = 'id_medicamento';

    
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

    public function alergias()
    {
        return $this->hasMany('App\Models\Alergias', 'medicamento');
    }

    public function medicamento_cita()
    {
        return $this->hasMany('App\Models\MedicamentoCita', 'medicamento');
    }
}
