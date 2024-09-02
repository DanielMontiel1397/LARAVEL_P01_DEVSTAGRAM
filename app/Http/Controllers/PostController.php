<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller implements HasMiddleware
{
    //Verificar si hay un usuario autenticado

    public static function middleware(){
        return [
            new Middleware('auth', except:['show','index'])
        ];
    }
        
    public function index(User $user){

        //Obtenemos los posts realizados por el usuario autenticado
        $posts = Post::where('user_id', $user->id)->latest()->paginate(3);

        //Cargamos una vista, y le enviamos las variables requeridas.
        return view('dashboard',[
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function create(){
        return view('posts.create');
    }

    public function store(Request $request){

        $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);

        /* 
        Post::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => Auth::user()->id
        ]);

        */
        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('post.index', Auth::user()->username);
    }

    public function show(User $user, Post $post ){
        return view('posts.show', [
            'post' => $post,
            'user' => $user
        ]);
    }

    public function destroy(Post $post){

        Gate::allows('delete', $post);
        
        $post->delete();

        //Eliminar la imagen
        $imagenPath = public_path('uploads/' . $post->imagen);
        if(File::exists($imagenPath)){
            unlink($imagenPath);
        }
        
        return redirect()->route('post.index', Auth::user()->username);
    }
}
