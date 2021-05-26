<?php

namespace App\Models;

use App\Models\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\App;
use League\Glide\Server;

class Portfolio extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'date:d-m-Y H:i',
        'updated_at' => 'date:d-m-Y H:i',
    ];

    public function getImgUrlAttribute()
    {
        //'w' => 400, 'h' => 400, 'fit' => 'crop'
        return $this->imgUrl(['w' => 100]);
    }

    public function getBigImgUrlAttribute()
    {
        //'w' => 400, 'h' => 400, 'fit' => 'crop'
        return $this->imgUrl([]);
    }

    public function imgUrl(array $attributes)
    {
        if ($this->img) {
            return URL::to(App::make(Server::class)->fromPath($this->img, $attributes));
        }
        return null;
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('body', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            });
        })->when($filters['category_id'] ?? null, function ($query, $category_id) {
            $query->whereHas('category', function ($query) use ($category_id) {
                $query->where('id', $category_id);
            });
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }

    public function scopeSort($query, $sort, $direction)
    {

        $direction = $direction ?? 'asc';
        $sort = $sort ?? 'id';

        if (!in_array($direction, ['asc', 'desc'])) {
            return $query;
        }

        if ($sort !== 'category') {
            $query->orderBy($sort, $direction);
        } else {
            $orderByRaw = \DB::raw("(select name from categories where notes.category_id = categories.id) $direction");
            $query->orderByRaw($orderByRaw);
        }

        return $query;
    }
}
