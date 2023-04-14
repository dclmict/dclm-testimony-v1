<?php

namespace App\Http\Controllers;

use App\Http\Requests\VettedTestimonyRequest;
use App\Models\Country;
use App\Models\VettedTestimony;
use Illuminate\Http\Request;
use App\Models\CrusadeTour;

class VettedTestimoniesControler extends Controller
{
    public function create()
    {
        $countries = Country::orderBy('libelle')->get();
        return view('Admin.testimonies.vetted.create', compact('countries'));
    }

    public function store(VettedTestimonyRequest $request)
    {

        $testimony = VettedTestimony::store(
            $request->except("file_dir"),

            // chnage has('file_dir') to hasFile("file_dir")
            $request->hasFile("file_dir") ? file_get_contents($request->file('file_dir')->getRealPath()) : null,
            $request->hasFile("file_dir") ? $request->file('file_dir')->extension() : null
        );


        return redirect()->route('admin.testimony.vetted.list')->with('msg', 'Successfully');
    }

    public function list()
    {
        $vts = VettedTestimony::all();
        return view('Admin.testimonies.vetted.list', compact('vts'));
    }
}
