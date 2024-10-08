<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'start_time',
        'end_time',
        'total_gross',
        'total_expense',
        'total_profit',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity_sold', 'total_value');
    }

    public function user()
    {
        return $this->belongsTo(User::class); // O evento ativo pertence a um usuário
    }
}
