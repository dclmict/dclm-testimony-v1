<?php

namespace App\Models;

use App\Models\Country;
use App\Models\Testimony;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Testifier extends Model
{
    use HasFactory;

    protected $fillable = ["full_name", "country_id" , "city", "phone", "email"];

    public function testimonies()
    {
        return $this->hasMany(Testimony::class);
    }

    public static function existOrCreate($data)
    {

        $testifier = Testifier::where('email', $data['email'])->first();
        if ($testifier) {
            return $testifier;
        }
        $data = collect($data)->only(['full_name', 'email', 'phone', 'city', 'country_id'])->toArray();

        $country = Country::find($data['country_id']);
        $testifier = Testifier::make($data);
        $testifier->country()->associate($country);
        $testifier->save();

        return $testifier;
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }
}
