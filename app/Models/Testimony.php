<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimony extends Model
{
    use HasFactory;

    protected $guarded = [ ];

    public static function store(array $data, $file)
    {
        $testimony = self::create($data);

        $testimony->saveFile($file);
    }

    public function saveFile($file)
    {
        
    }
}
