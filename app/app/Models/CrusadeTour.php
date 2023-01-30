<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CrusadeTour extends Model
{
    use HasFactory;

    protected $fillable = ["slug", "name", "banner_path"];

    public  function store(array $data, $file)
    {
        $crusadeTour = self::make(collect($data)->only(["slug", "name"])->toArray());


        if ($file) {
            $crusadeTour->banner_path =  $crusadeTour->storeFile($file);
        }

        $crusadeTour->save();
        return $crusadeTour;
    }

    public  function  storeFile($file)
    {
        $extension = $file->getClientOriginalExtension();

        $fileName = $this->slug . '-' . time() . '.' . $extension;

        try {
            $file->store("dclm-testimony/" . "crusade-tours/banners/" . $fileName, "s3");
        } catch (Exception $e) {
        }

        return $fileName;
    }

    public function testimonies()
    {
        return $this->hasMany(Testimony::class);
    }




    public function getBannerAttribute()
    {
        return Storage::disk('s3')
            ->temporaryUrl("dclm-testimony/crusade-tours/banners" . $this->slug . "/" . $this->banner_path, now()->addDays(6));
    }

    public function deleteBanner()
    {
        try {
            Storage::disk('s3')->delete("dclm-testimony/crusade-tours/banners" . $this->crusadeTour->slug . "/" . $this->banner_path);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
