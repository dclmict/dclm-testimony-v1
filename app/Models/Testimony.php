<?php

namespace App\Models;

use App\Models\Testifier;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Testimony extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function store(array $data, $file, $extension)
    {
        $testimony = self::create($data);

        if ($file) {

            $testimony->saveFile($file, $extension);
        }
    }

    public function saveFile($file, $extension)
    {


        $fileName = $this->email . '-' . time() . '.' . $extension;
        try {
            Storage::disk('s3')->put("abeokuta-crusade/".$fileName, $file);
            $this->file_dir = $fileName;
            $this->save();
        } catch (\Throwable $th) {

            Log::error($th->getMessage());
        }
    }


    public function testifier()
    {
        return $this->belongsTo(Testifier::class);
    }
}
