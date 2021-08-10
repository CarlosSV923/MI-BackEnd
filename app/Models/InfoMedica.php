<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoMedica extends Model
{
    protected $table = 'info_medica';
    protected $primaryKey = 'id_info_medica';

                     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unidad', "seguimiento", "cita","value", "key", 'created_at', "descrip"
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    	 'updated_at'
    ];

    public function citas()
    {
        return $this->belongsTo('App\Models\Citas', 'cita');
    }

    public function seguimientos()
    {
        return $this->belongsTo('App\Models\Seguimientos', 'seguimiento');
    }
}
