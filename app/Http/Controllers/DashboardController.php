<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;
use App\Models\Church;
use App\Models\District;
use App\Models\Zone;
use App\Models\Sector;
use App\Models\Network;
use App\Models\House;
use Carbon\Carbon;

class DashboardController extends Controller {
    public function index(){
        $data = [
            'users' =>  User::with('church')->find(2),
            'date' => now()->subMinute()->diffForHumans(),
            'houses' => District::find(1)->houses,
        ];
        

        return Inertia::render('Dashboard',$data);
    }
}
