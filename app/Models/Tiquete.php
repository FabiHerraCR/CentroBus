<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiquete extends Model
{
    protected $table = 'tiquetes';

    protected $fillable = [
        'cliente_id',
        'ruta_id',
        'fecha_viaje',
        'codigo',
        'precio',
    ];

    public function ruta()
    {
        return $this->belongsTo(Ruta::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}