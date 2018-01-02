<?php

namespace App\Http\Controllers;

use App\Like;
use Faker\Provider\File;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PostController extends Controller{

    /**
     * @param Request $request
     */
    public function create(Request $request){

        //Validation
        $this->validate($request, [
            'title' => 'required|max:200',
            'body' => 'required|max:1000',
            'image' => 'required'
        ]);

        $user = Auth::user();
        $post = new Post();
        $post->title = $request['title'];
        $post->body = $request['body'];

        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = $user->id.'-'.time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('articles')->put($filename, file_get_contents($request->file('image')->getRealPath()));
            $post->image = $filename;
        }

        $message = "Quelque chose n'a pas marché !";
        if ($request->user()->posts()->save($post)){
            $message = "L'article a été ajouté avec succès !";
        }
        return redirect()->route('home')->with(['message' => $message]);
    }

    public function dashboard(){
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('post.dashboard', ['posts' => $posts]);
    }

    public function delete($post_id){
        $post = Post::where('id', $post_id)->first();
        if(Auth::user() != $post->user){
            return redirect()->back();
        }
        $post->delete();
        return redirect()->route('post.dashboard', ['message' => "Article supprimé avec succès !"]);
    }

    public function edit(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'body'  => 'required'
        ]);
        $post = Post::find($request['postId']);
        if(Auth::user() != $post->user){
            return redirect()->back();
        }
        $post->title = $request['title'];
        $post->body = $request['body'];
        $post->update();
        return response()->json(['new_body' => $post->body, 'new_title' => $post->title,], 200);
    }

    public function like(Request $request){
        $post_id = $request['postId'];
        $is_like = $request['isLike'] === 'true';
        $update = false;
        $post = Post::find($post_id);
        if (!$post){
            return null;
        }
        $user = Auth::user();
        $like = $user->likes()->where('post_id', $post_id)->first();
        if ($like){
            $already_like = $like->like;
            $update = true;
            if ($already_like == $is_like){
                $like->delete();
                return null;
            }
        } else{
            $like = new Like();
        }
        $like->like = $is_like;
        $like->user_id = $user->id;
        $like->post_id = $post->id;
        if ($update){
            $like->update();
        }else{
            $like->save();
        }
        return null;
    }

}
