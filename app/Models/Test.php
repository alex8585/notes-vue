<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Record;
use App\Models\Firmware;

class Test extends Model
{
    use HasFactory;
    public function firmvares()
    {
        return $this->belongsToMany(Firmware::class, 'records', 'test_id', 'firmware_id');
    }
}
