<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = ['sala_id', 'usuario', 'data', 'horario'];

    // RELAÇÃO: Uma reserva pertence a uma sala
    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }
}
