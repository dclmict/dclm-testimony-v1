<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrusadeTour extends Model
{
    use HasFactory;

    protected $fillable = ["slug"];

    public static function store(array $data)
    {
        $crusadeTour = self::create($data);

        return $crusadeTour;
    }

    public function testimonies()
    {
        return $this->hasMany(Testimony::class);
    }
}
