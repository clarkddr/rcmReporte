<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Church;
use Inertia\Inertia;

class ChurchController extends Controller
{
    public function show(){
        $churchid = auth()->user()->church_id;
        $church = Church::findOrFail($churchid);
        $data = [
            'church' => $church
        ];
        return Inertia::render('Church/Show',$data);
    }

    public function update(Request $request){
        $churchid = auth()->user()->church_id;
        $church = Church::findOrFail($churchid);
        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
        ]);
        $church->name = $request->name;
        $church->number = $request->number;
        $church->address = $request->address;
        $church->saveOrFail();
        return redirect()->back();
    }
}
