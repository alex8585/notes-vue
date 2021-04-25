<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'created_at' => 'date:d-m-Y H:i',
        'updated_at' => 'date:d-m-Y H:i',
    ];

    public function scopeSort($query, $sort, $direction)
    {

        $direction = $direction ?? 'asc';
        $sort = $sort ?? 'id';

        if (!in_array($direction, ['asc', 'desc'])) {
            return $query;
        }

        $query->orderBy($sort, $direction);

        return $query;
    }

    public function getSymbolIdAttribute()
    {
        return str_replace("/", "",  $this->symbol);
    }
}
