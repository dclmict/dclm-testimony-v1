<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestimonyRequest;
use App\Models\Country;
use App\Models\Testimony;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestimonyFormController extends Controller
{
    public function show()
    {
        $countries = Country::orderBy("libelle")->get();

        return view('create', compact("countries"));
    }

    public function store(TestimonyRequest $request)
    {
      
        $testimony = Testimony::store(
            $request->except("file_dir"), //data
            
            $request->has("file_dir") ? file_get_contents($request->file('file_dir')->getRealPath()) : null, //file
            $request->has("file_dir") ? $request->file('file_dir')->extension() : null // extension 
        );

        return "thnaks it isfixed";
        //dd($testimony);
       
    }

    public function thanks()
    {
        return view('thanks');
    }
}
