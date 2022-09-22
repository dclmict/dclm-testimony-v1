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
            $request->except("file_dir"),
           
            $request->has("file_dir") ? file_get_contents($request->file('file_dir')->getRealPath()) : null,
            $request->has("file_dir") ? $request->file('file_dir')->extension() : null
        );


        //dd($testimony);
        return response(['msg' => 'Succesful']);
    }

    public function thanks()
    {
        return view('thanks');
    }
}
