<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Admin extends Controller
{
    public function show()
    {
        return view('admin.layout.main');
    }
}
