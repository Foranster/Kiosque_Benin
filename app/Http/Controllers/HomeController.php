<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Slide;

class HomeController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('home');
    }

    public function account(){
        return view('account', ['user' => Auth::user()]);
    }

    public function saveAccount(Request $request){
        $this->validate($request, [
            'surname' => 'required|max:120'
        ]);
        $user = Auth::user();
        $user->surname = $request['surname'];
        $user->update();
        $file = $request->file('image');
        $filename = $request['surname'] . '-' .$user->id . '.jpg';
        if ($file){
            Storage::disk('local')->put($filename, File::get($file));
        }
        return redirect()->route('user.account');
    }

    public function image($filename){
        $file = Storage::disk('local')->get($filename);
        return new Response($file, 200);
    }
}
