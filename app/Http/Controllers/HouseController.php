<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class HouseController extends Controller {
    public function index(Request $request) {
        $houses = House::query()
        ->when($request->input('search'), function ($query, $search) {
            $query->where('number','like', '%' . $search . '%')
            ->orWhere('address','like', '%' . $search . '%');            
        })->orderBy('created_at','desc')
        ->paginate(10)->withQueryString()
        ->through(function ($house) {
            return [
                'id' => $house->id,
                'number' => $house->number,
                'address' => $house->address,
                'created_at_human' => Carbon::parse($house->created_at)->diffForHumans(),
                'updated_at_human' => Carbon::parse($house->updated_at)->diffForHumans(),
                // 'created_at' => Carbon::parse($house->created_at)->toFormattedDayDateString(),
                // 'created_at' => ucwords(Carbon::parse($house->created_at)->translatedFormat('dddd d F Y H:s')),
                'created_at' => ucwords(Carbon::parse($house->created_at)->isoFormat('dddd D MMMM YYYY H:ss')),
                'updated_at' => ucwords(Carbon::parse($house->updated_at)->isoFormat('dddd D MMMM YYYY H:ss'))
            ];
        });
        // return $users;
        $data = [
            'houses' => $houses,
            'filter' => $request->only(['search'])
        ];
        return Inertia::render('House/Index',$data);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $request->validate([
            'number' => 'required',
            'address' => 'required',
        ]);
        
        $house = new House();
        $house->church_id = 1;
        $house->network_id = 1;
        $house->number = $request->number;
        $house->address = $request->address;
        $house->saveOrFail();
        return redirect()->route('houses.index')->with('succes','Casa de bendición agregada exitosamente!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(House $house) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) {
        $house = House::findOrFail($request->id);
        $request->validate([
            'number' => 'required',
            'address' => 'required',
        ]);
        $house->number = $request->number;
        $house->address = $request->address;
        $house->saveOrFail();                
        $newHouse = [
            'id' => $house->id,
            'number' => $house->name,
            'address' => $house->address,
            'created_at_human' => Carbon::parse($house->created_at)->diffForHumans(),
            'updated_at_human' => Carbon::parse($house->updated_at)->diffForHumans(),
            'created_at' => ucwords(Carbon::parse($house->created_at)->isoFormat('dddd D MMMM YYYY H:ss')),
            'updated_at' => ucwords(Carbon::parse($house->updated_at)->isoFormat('dddd D MMMM YYYY H:ss'))
        ];
        // return ucwords(Carbon::parse($user->updated_at)->isoFormat('dddd D MMMM YYYY H:ss'));
        $request->session()->flash('flash.banner', 'Casa actualizada exitosamente!!');
        $request->session()->flash('flash.bannerStyle', 'success');
        $request->session()->flash('flash.house', $newHouse);
        return redirect()->back();        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, House $house) {
        $house->delete();
        $request->session()->flash('flash.banner', 'Casa eliminada exitosamente!!');
        $request->session()->flash('flash.bannerStyle', 'success');
        return redirect()->back();
    }
}
