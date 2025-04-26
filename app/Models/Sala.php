<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'nome',
        'capacidade',
    ];

    // Uma sala possui várias reservas
    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
