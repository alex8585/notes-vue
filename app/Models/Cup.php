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

    protected $casts = [
        'params' => 'array',
    ];

    public function getImgUrlAttribute()
    {
        //'w' => 400, 'h' => 400, 'fit' => 'crop'
        return $this->imgUrl([]);
    }


    public function getCroppedImgUrlAttribute()
    {
        $p = $this->params;
        return $this->imgUrl(['crop' => "{$p['width']},{$p['height']},{$p['left']},{$p['top']}"]);
    }

    public function getImgThumnailbUrlAttribute()
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
