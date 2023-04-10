<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VettedTestimoniesControler extends Controller
{
    public function create()
    {
        return view('Admin.testimonies.vetted.create');
    }
}
