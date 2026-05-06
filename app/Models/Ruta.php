<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    protected $table = 'rutas';

    protected $fillable = [
        'origen',
        'destino',
        'horario',
        'precio',
    ];

    public function horarioFormateado(): string
    {
        return Carbon::createFromFormat('H:i:s', $this->horario)->format('g:i A');
    }
}
