<?php

namespace App\Http\Controllers;

use App\Models\Network;
use App\Models\Church;
use App\Models\Sector;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NetworkController extends Controller
{
    public function index() {
        $church = Church::findOrFail(auth()->user()->church_id);
        $networks = $church->networks()->with('sector.zone.district', 'houses')->paginate(10);

        // Mapea los resultados paginados
        $networks->getCollection()->transform(function ($network) {
            return [
                'id' => $network->id,
                'number' => $network->number,
                'sector' => $network->sector,
                'zone' => $network->sector->zone,
                'district' => $network->sector->zone->district,
                'houses' => $network->houses,
                'houses_quantity' => $network->houses->count(),
                'created_at_human' => Carbon::parse($network->created_at)->diffForHumans(),
                'updated_at_human' => Carbon::parse($network->updated_at)->diffForHumans(),
                'created_at' => ucwords(Carbon::parse($network->created_at)->isoFormat('dddd D MMMM YYYY H:ss')),
                'updated_at' => ucwords(Carbon::parse($network->updated_at)->isoFormat('dddd D MMMM YYYY H:ss'))
            ];
        });        
        
        $sectors = Sector::with(['district','zone'])->get();

        $data = [
            'networks' => $networks,
            'churchStructure' => Church::with(['districts','zones','sectors'])->findOrFail(1),
            'sectors' => $sectors
        ];
        return Inertia::render('Network/Index',$data);
    }

    public function show(Network $network){   
        $houses = $network->houses->map(function ($house) {
            return [
                'id' => $house->id,
                'number' => $house->number,
                'sector_id' => $house->sector_id,                
                'created_at_human' => Carbon::parse($house->created_at)->diffForHumans(),
                'updated_at_human' => Carbon::parse($house->updated_at)->diffForHumans(),
                'created_at' => ucwords(Carbon::parse($house->created_at)->isoFormat('dddd D MMMM YYYY H:ss')),
                'updated_at' => ucwords(Carbon::parse($house->updated_at)->isoFormat('dddd D MMMM YYYY H:ss'))
            ];
        });     
        $data = [
            'network' => $network,
            'houses' => $houses,
        ];
        
        return Inertia::render('Network/Show',$data);

    }

    public function store(Request $request){
        $attributes = $request->validate([
            'number' => ['required','numeric','gt:0'],
            'sector_id' => ['exists:sectors,id']
        ]);

        Network::create($attributes);



        return redirect('/networks');
    }
}
