<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Testifier;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;

class VettedTestimony extends Model
{
    use HasFactory;

    protected $fillable = ["name", "email", "country_id", "city", "phone", "msg"];



    public static function store(array $data, $file, $extension)
    {
        // alternative to new Testimony()   plus second work around for say, $st = new Stuff();
        //$st->name = $req->name ---- etc instead of doing it one by one, just inject it all at once
        $testimony = self::make(collect($data)->only(["content"])->toArray());

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
            //get presigned url
            //$url = Storage::disk('s3')->temporaryUrl("dclm-testimony/" . $this->crusade_tour->slug . "/" . $this->file_dir, now()->addMinutes(5))
            $url = $this->file_dir != null ? Storage::disk('s3')
                ->temporaryUrl("dclm-testimony/" . $this->crusadeTour->slug . "/" . $this->file_dir, now()->addDays(6)) : null;

            return $url;
        } catch (\Throwable $th) {

            Log::error($th->getMessage());
        }

        return null;
    }


}
