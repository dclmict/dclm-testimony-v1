<?php

namespace App\Http\Controllers;

use App\Models\CrusadeTour;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function show()
    {
        $active= CrusadeTour::whereIsActive(true)->first() ;

        return view('admin.index', compact('active'));
    }
}
