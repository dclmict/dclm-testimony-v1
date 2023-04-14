<?php

namespace App\Http\Controllers;

use App\Http\Requests\VettedTestimonyRequest;
use App\Models\Country;
use App\Models\VettedTestimony;
use Illuminate\Http\Request;
use App\Models\CrusadeTour;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class VettedTestimoniesControler extends Controller
{


    public function create()
    {
        $countries = Country::orderBy('libelle')->get();
        $crusadeTours = CrusadeTour::get(['id', 'name']);
        return view('Admin.testimonies.vetted.create', compact('countries', 'crusadeTours'));
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

    public function list(Request $r)
    {

        $vts = new VettedTestimony();

        $crusadeTours = CrusadeTour::all();

        if ($r->has('crusadeTour')) {
            //fetch category
            $vts = VettedTestimony::where('crusade_tour', $r->crusadeTour)->get();

            return view('Admin.testimonies.vetted.list', compact('vts', 'crusadeTours'));
        }

        $vts = $vts->get();

        return view('Admin.testimonies.vetted.list', compact('vts', 'crusadeTours'));
    }



    public function delete(VettedTestimony $vt)
    {
        $vt = VettedTestimony::with('crusadeTour')->findOrFail($vt->id);
        //$testimony->testifier->delete(); dangerous line never delete the testifier
        //delete testimony file from s3


        $file = $vt->file_dir;
        try {
            Storage::disk('s3')->delete("dclm-testimony/vt/" . $vt->crusadeTour->slug . "/" . $file);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }

        $vt->delete();
        return redirect()->route('admin.testimony.vetted.list');
        //or
        // $testimony = Testimony::findOrFail($testimony->id);
        // $testimony->delete();
    }
}
