<?php

namespace App\Models;

use App\Models\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use League\Glide\Server;

class Cup extends Model
{
    use HasFactory;


    public function getImgUrlAttribute()
    {
        return $this->imgUrl(['w' => 400, 'h' => 400, 'fit' => 'crop']);
    }

    public function getImgUrl20Attribute()
    {
        return $this->imgUrl([]);
    }

    public function imgUrl(array $attributes)
    {
        if ($this->img) {
            return URL::to(App::make(Server::class)->fromPath($this->img, $attributes));
        }
        return null;
    }
}
