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
        $testimony = self::make(collect($data)->only(["content"])->toArray());
        $active = CrusadeTour::whereIsActive(true)->first();

        $testifier = Testifier::existOrCreate($data);
        $testimony->testifier()->associate($testifier);

        /* Warning : make sure $active is not null */
        $testimony->crusadeTour()->associate($active);

        $testimony->save();

        if ($file) {

            $testimony->saveFile($file, $extension);
        }
    }

    public function saveFile($file, $extension)
    {
        $fileName = $this->testifier->email . '-' . time() . '.' . $extension;
        $active = CrusadeTour::whereIsActive(true)->first();

        try {
            Storage::disk('s3')->put("dclm-testimony/" . $active->slug . "/" . $fileName, $file);
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


    public function crusadeTour()
    {
        return $this->belongsTo(CrusadeTour::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }


    public function getFileTypeAttribute()
    {
        return $this->file_dir ? mime_content_type($this->file_dir) : null;
    }

    public function getPathAttribute()
    {

        try {
            return $this->file_dir ? Storage::disk('s3')->get("dclm-testimony/" . $this->crusadeTour->slug . "/" . $this->file_dir) : null;
        } catch (\Throwable $th) {

            Log::error($th->getMessage());
        }

        return null;
    }
}
