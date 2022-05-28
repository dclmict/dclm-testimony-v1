<?php

namespace App\Http\Controllers;

use App\Models\Testimony;
use App\Models\CrusadeTour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class AdminController extends Controller
{
    public function index()
    {
        $active = CrusadeTour::whereIsActive(true)->first();
        $user = 'Admin';

        return view('admin.index', compact('active',))->with('user', $user);
    }

    public function testimoniesList()
    {
        $testimonies = Testimony::with('testifier')->with('country')->latest()->get();
        return view('Admin.testimonies.list', compact('testimonies'));
    }

    public function show(Testimony $testimony)
    {
        $testimony = Testimony::with('testifier')->with('country')->findOrFail($testimony->id);
        return view('Admin.testimonies.show', compact('testimony'));
    }

    public function delete(Testimony $testimony)
    {
        $testimony = Testimony::with('testifier')->findOrFail($testimony->id);

        //$testimony->testifier->delete(); dangerous line never delete the testifier

        //delete testimony file from s3
        $active = CrusadeTour::whereIsActive(true)->first();
        $file = $testimony->file_dir;
        try {
            Storage::disk('s3')->delete("dclm-testimony/" . $active->slug . "/" . $file);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }



        $testimony->delete();

        return redirect()->route('admin.testimonies.list');

        //or

        // $testimony = Testimony::findOrFail($testimony->id);
        // $testimony->delete();
    }
}
