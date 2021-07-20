<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuidadorSeguimiento extends Model
{
    protected $table = 'cuidador_seguimiento';
    protected $primaryKey = 'id_cuidador_seguimiento';

                /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "cuidador", "seguimiento"
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

    public function seguimientos()
    {
        return $this->belongsTo('App\Models\Seguimientos', 'seguimiento');
    }
}
