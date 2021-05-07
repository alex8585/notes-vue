<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model;

class Market extends Model
{
    use HasFactory;

    public function getSymbolIdAttribute()
    {
        return str_replace("/", "",  $this->symbol);
    }
}
