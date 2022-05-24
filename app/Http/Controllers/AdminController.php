<?php

namespace App\Http\Controllers;

use App\Models\CrusadeTour;
use App\Models\Testimony;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function show()
    {
        $active = CrusadeTour::whereIsActive(true)->first();

        return view('admin.index', compact('active'));
    }

    public function testimoniesList()
    {
        $testimonies = Testimony::with('testifier')->get();
        return view('Admin.testimonies.list', compact('testimonies'));
    }
}
