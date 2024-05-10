<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        return redirect()->back();
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
        return redirect()->route('table');
    }
    public function destroy(User $user){
        $user->delete();
        return redirect()->back();
    }
}
