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
        $users = User::query()
        ->when($request->input('search'), function ($query, $search) {
            $query->where('name','like', '%' . $search . '%')
            ->orWhere('username','like', '%' . $search . '%')
            ->orWhere('email','like', '%' . $search . '%');
        })
        ->with('church')
        ->paginate(10)
        ->through(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'type' => $user->type,
                'church' => [
                    'church_id' => $user->church->church_id,
                    'name' => $user->church->name
                ]                
            ];
        });
        
        $data = [
            'users' => $users
        ];
        return Inertia::render('Table',$data);
    }
}
