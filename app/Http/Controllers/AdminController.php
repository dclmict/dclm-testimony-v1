<?php

namespace App\Http\Controllers;

use App\Models\Testimony;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function show()
    {
        return view('Admin.layout.main');
    }

    public function testimoniesList()
    {
        $testimonies = Testimony::with('testifier')->get();
        return view('Admin.testimonies.list', compact('testimonies'));
    }
}
