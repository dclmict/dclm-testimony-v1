<?php

namespace App\Http\Controllers;

use App\Http\Requests\VettedTestimonyRequest;
use App\Models\Country;
use App\Models\VettedTestimony;
use Illuminate\Http\Request;

class VettedTestimoniesControler extends Controller
{
    public function create()
    {
        $countries = Country::orderBy('libelle')->get();
        return view('Admin.testimonies.vetted.create', compact('countries'));
    }

    public function store(VettedTestimonyRequest $request)
    {
        $vt = new VettedTestimony();
        
        
    }
}
