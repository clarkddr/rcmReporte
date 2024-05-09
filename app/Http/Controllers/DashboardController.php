<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;
use App\Models\Church;

class DashboardController extends Controller {
    public function index(){
        $data = [
            'users' =>  User::with('church')->find(2)
        ];

        return Inertia::render('Dashboard',$data);
    }

    public function table(Request $request){
        $data = [
            'users' => User::with('church')->get()
        ];
        return Inertia::render('Table',$data);
    }
}
