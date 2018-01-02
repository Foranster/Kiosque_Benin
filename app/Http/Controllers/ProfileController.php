<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Profile;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller{
    public  function  index($email){
        if(Auth::user()->email != $email)
            return redirect()->back();

        $user = Auth::user()->where('email', $email)->first();

        return view('user.profile')->with('user', $user);
    }

    public function avatarUpdate(Request $request){
        $this->validate($request, [
            'avatar'  => 'required'
        ]);
        $user = Auth::user()->find($request['userId']);
        /*if(Auth::user() != $user){
            return redirect()->back();
        }*/
        if($request->hasFile('avatar')){
            Auth::user()->update([
                'avatar' => $request->avatar
            ]);
        }
        $user->avatar = $request['avatar'];
        $user->update();
        return response()->json(['new_avatar' => $user->avatar], 200);
    }
}

