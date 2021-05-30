<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model;
use App\Models\Media;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function medias()
    {
        return $this->morphedByMany(Media::class, 'taggable');
    }
}
