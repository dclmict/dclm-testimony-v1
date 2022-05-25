<?php

namespace App\Http\Controllers;

use App\Models\CrusadeTour;
use App\Models\Testimony;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function index()
    {
        $active = CrusadeTour::whereIsActive(true)->first();

        return view('admin.index', compact('active'));
    }

    public function testimoniesList()
    {
        $testimonies = Testimony::with('testifier')->with('country')->get();
        return view('Admin.testimonies.list', compact('testimonies'));
    }

    public function show(Testimony $testimony)
    {
        $testimony = Testimony::with('testifier')->with('country')->findOrFail($testimony->id);
        return view('Admin.testimonies.show', compact('testimony'));
    }

    public function delete(Testimony $testimony)
    {
        $testimony = Testimony::with('testifier')->with('country')->findOrFail($testimony->id);

        $testimony->delete();

        return redirect()->route('admin.testimonies.list');

        //or 

        // $testimony = Testimony::findOrFail($testimony->id);
        // $testimony->delete();
    }
}
