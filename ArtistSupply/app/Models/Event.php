<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'data_inicio',
        'data_fim',
        'local',
        'descricao',
        'extra',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
