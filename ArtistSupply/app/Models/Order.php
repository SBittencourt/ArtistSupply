<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'quantia',
        'preco',
        'local',
        'descricao',
        'fornecedor',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
