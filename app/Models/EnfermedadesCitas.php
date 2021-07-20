<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnfermedadesCitas extends Model
{
    protected $table = 'enfermedades_citas';
    protected $primaryKey = 'id_enfermedad_cita';

                    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "enfermedad", "cita"
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function enfermedades()
    {
        return $this->belongsTo('App\Models\Enfermedades', 'enfermedad');
    }

    public function citas()
    {
        return $this->belongsTo('App\Models\Citas', 'cita');
    }
}
