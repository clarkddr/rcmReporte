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

    public function table(Request $request){
        $users = User::query()
        ->when($request->input('search'), function ($query, $search) {
            $query->where('name','like', '%' . $search . '%')
            ->orWhere('username','like', '%' . $search . '%')
            ->orWhere('email','like', '%' . $search . '%');
        })->orderBy('created_at','desc')
        ->with('church')
        ->paginate(10)->withQueryString()
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
                ],
                'created_at_human' => Carbon::parse($user->created_at)->diffForHumans(),
                'updated_at_human' => Carbon::parse($user->updated_at)->diffForHumans(),
                // 'created_at' => Carbon::parse($user->created_at)->toFormattedDayDateString(),
                'created_at' => ucwords(Carbon::parse($user->created_at)->translatedFormat('D d F Y H:s')),
                'updated_at' => Carbon::parse($user->updated_at)->toFormattedDayDateString()
            ];
        });
        // return $users;
        $data = [
            'users' => $users,
            'filter' => $request->only(['search'])
        ];
        return Inertia::render('Table',$data);
    }
}
