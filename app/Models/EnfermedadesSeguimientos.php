<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnfermedadesSeguimientos extends Model
{
    protected $table = 'enfermedades_seguimientos';
    protected $primaryKey = 'id_enfermedad_seguimiento';

                    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "enfermedad", "seguimiento"
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

    public function seguimientos()
    {
        return $this->belongsTo('App\Models\Seguimientos', 'seguimiento');
    }
}
