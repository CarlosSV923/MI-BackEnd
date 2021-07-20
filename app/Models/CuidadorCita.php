<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuidadorCita extends Model
{
    protected $table = 'cuidador_cita';
    protected $primaryKey = 'id_cuidador_cita';

                /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "cuidador", "cita"
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function cuidadores()
    {
        return $this->belongsTo('App\Models\Personas', 'cuidador');
    }

    public function citas()
    {
        return $this->belongsTo('App\Models\Citas', 'cita');
    }
}
