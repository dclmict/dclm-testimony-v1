<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestimonyRequest;
use App\Models\Country;
use App\Models\Testimony;
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
            $request->except("file_dire"), 
            file_get_contents($request->file('file_dir')->getRealPath()),
            $request->file('file_dir')->extension()
        );

        return redirect()->route("thanks");
    }

    public function thanks()
    {
        return view('thanks');
    }
}
