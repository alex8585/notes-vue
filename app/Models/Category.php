<?php

namespace App\Models;

use App\Models\Note;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Category extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at' => 'date:d-m-Y H:i',
        'updated_at' => 'date:d-m-Y H:i',
    ];


    public function notes()
    {
        return $this->hasMany(Note::class);
    }

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
}
