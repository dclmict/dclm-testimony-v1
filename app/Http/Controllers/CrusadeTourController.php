<?php

namespace App\Http\Controllers;

use App\Models\CrusadeTour;
use Exception;
use Illuminate\Http\Request;

class CrusadeTourController extends Controller
{
    //


    public function index()
    {
        return view("admin.crusade-tour", ["crusadeTours" => CrusadeTour::all(), "ct" => null]);
    }

    public function create()
    {
        //

        return view('admin.crusade-tour');
    }


    public function store(Request $request)
    {
        //
        $request->validate(["slug" => "required|unique:crusade_tours"]);

        CrusadeTour::store($request->only(["slug"]));

        return redirect()->route("admin.crusade-tour.index");
    }

    public function active($id)
    {

        $active = CrusadeTour::whereIsActive(true)->first();

        if ($active) {
            $active->is_active = false;
            $active->save();
        }


        try {
            $current  = CrusadeTour::findOrFail($id);
            $current->is_active = true;
            $current->save();
        } catch (Exception $e) {
        }

        return redirect()->route("admin.crusade-tour.index");
    }

    public function update($id, Request $request)
    {
        $request->validate(["slug" => "required|unique:crusade_tours"]);

        try {
            $current  = CrusadeTour::findOrFail($id);
            $current->slug = $request->slug;
            $current->save();
        } catch (Exception $e) {
        }
        return redirect()->route("admin.crusade-tour.index");
    }

    public function delete($id)
    {
        try {
            $current  = CrusadeTour::findOrFail($id);

            if ($current->testimonies->count() == 0)
                $current->delete();
        } catch (Exception $e) {
        }

        return redirect()->route("admin.crusade-tour.index");
    }

    public function edit($id)

    {
        $ct = CrusadeTour::findOrFail($id);
        return view("admin.crusade-tour", ["ct" => $ct, "crusadeTours" => CrusadeTour::all()]);
    }
}
