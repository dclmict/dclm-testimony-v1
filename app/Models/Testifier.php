<?php

namespace App\Models;

use App\Models\Testimony;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Testifier extends Model
{
    use HasFactory;


    public function testimonies(){
        return $this->hasMany(Testimony::class);
    }
}
