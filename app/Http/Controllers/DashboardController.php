<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;
use App\Models\Church;
use Carbon\Carbon;

class DashboardController extends Controller {
    public function index(){
        $data = [
            'users' =>  User::with('church')->find(2),
            'date' => now()->subMinute()->diffForHumans()
        ];

        return Inertia::render('Dashboard',$data);
    }
}
