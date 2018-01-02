<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Slide;

class SlideController extends Controller{
    public function show(){
        $slides = Slide::all();
        return view('welcome', ['slides' => $slides]);
    }

    public function view(){
        $slides = Slide::all();
        return view('slide.view', ['slides' => $slides]);
    }

    public function edit(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'description'  => 'required'
        ]);
        $slide = Slide::find($request['slideId']);
        $slide->title = $request['title'];
        $slide->description = $request['description'];
        $slide->update();
        return response()->json(['new_title' => $slide->title, 'new_description' => $slide->description], 200);
    }
}
