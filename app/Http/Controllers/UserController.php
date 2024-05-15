<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'email|unique:users',
            'type' => 'required',
        ]);
        
        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->type = $request->type;
        $user->password = 'iafcj';
        $user->church_id = Auth::user()->church_id;
        $user->save();
        $request->session()->flash('flash.banner', 'Usuario guardado exitosamente!!');
        $request->session()->flash('flash.bannerStyle', 'success');
        return redirect()->route('table');
    }
    public function update(Request $request){
        $user = User::findOrFail($request->id);        
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,'.$user->id,
            'email' => 'email',
            'type' => 'required',
        ]);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->type = $request->type;
        $user->saveOrFail();                
        $newUser = [
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
            'created_at' => ucwords(Carbon::parse($user->created_at)->isoFormat('dddd D MMMM YYYY H:ss')),
            'updated_at' => ucwords(Carbon::parse($user->updated_at)->isoFormat('dddd D MMMM YYYY H:ss'))
        ];
        // return ucwords(Carbon::parse($user->updated_at)->isoFormat('dddd D MMMM YYYY H:ss'));
        $request->session()->flash('flash.banner', 'Usuario actualizado exitosamente!!');
        $request->session()->flash('flash.bannerStyle', 'success');
        $request->session()->flash('flash.user', $newUser);
        return redirect()->back();
    }
    public function destroy(Request $request,User $user){
        $user->delete();
        $request->session()->flash('flash.banner', 'Usuario eliminado exitosamente!!');
        $request->session()->flash('flash.bannerStyle', 'success');
        return redirect()->back();
    }
}
