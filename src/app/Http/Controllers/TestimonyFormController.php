<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestimonyRequest;
use App\Models\Country;
use App\Models\CrusadeTour;
use App\Models\Testimony;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestimonyFormController extends Controller
{
    public function show()
    {
        $countries = Country::orderBy("libelle")->get();
        $active_crusade = CrusadeTour::whereIsActive(true)->first();
        return view('welcome', compact("countries", 'active_crusade'));
    }

    public function store(TestimonyRequest $request)
    {
        $testimony = Testimony::store(
            $request->except("file_dir"),

            // chnage has('file_dir') to hasFile("file_dir")
            $request->hasFile("file_dir") ? file_get_contents($request->file('file_dir')->getRealPath()) : null,
            $request->hasFile("file_dir") ? $request->file('file_dir')->extension() : null
        );


        /*   $testimony = Testimony::store(
                $request->except("file_dir"),
                $request->has("file_dir") ? file_get_contents($request->file('file_dir')->getRealPath()) : null,modal-dialog-scrollable
                $request->has("file_dir") ? $request->file('file_dir')->extension() : null
            ); */


        //dd($testimony);
        return response(['msg' => 'Succesful']);
    }

    public function thanks()
    {
        return view('thanks', ["active_crusade" => CrusadeTour::whereIsActive(true)->first()]);
    }
}
