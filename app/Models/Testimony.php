<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Testimony extends Model
{
    use HasFactory;

    protected $guarded = [ ];

    public static function store(array $data, $file, $extension)
    {
        $testimony = self::create($data);

        $testimony->saveFile($file, $extension);
    }

    public function saveFile($file, $extension)
    {
        $fileName = $this->email.'-'.time().'.'.$extension;
        try {
            Storage::disk('s3')->put($fileName, $file);
            $this->file_dir = $fileName;
            $this->save();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
    }
}
