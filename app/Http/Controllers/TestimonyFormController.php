<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class TestimonyFormController extends Controller
{
    public function show()
    {
        $countries = Country::orderByDesc("libelle")->get();
        return view('create', compact("countries"));
    }
}
