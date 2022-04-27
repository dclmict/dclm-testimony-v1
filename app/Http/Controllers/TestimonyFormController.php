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
        $countries = Country::orderByDesc("libelle")->get();
        
        return view('create', compact("countries"));
    }

    public function store(TestimonyRequest $request)
    {
        $testimony = Testimony::store($request->except("file_dire"), $request->file_dire);
    }
}
