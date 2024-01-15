<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Str;
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

        $fileName = Str::slug($this->slug) . '-' . time() . '.' . $extension;

        try {
            // $file->store("dclm-testimony/" . "crusade-tours/banners/", "s3");

            $fileName = Storage::disk("s3")->put("/dclm-testimony/crusade-tours/banners/" . Str::slug($this->slug), $file);
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
        try {
            //code...
            $banner = Storage::disk('s3')
                ->temporaryUrl($this->banner_path, now()->addDays(6));
            return $banner;
        } catch (\Throwable $th) {

            return "https://";

            //throw $th;
        }
    }

    public function deleteBanner()
    {
        try {
            Storage::disk('s3')->delete($this->banner_path);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
