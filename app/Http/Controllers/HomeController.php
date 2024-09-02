<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class HomeController extends Controller implements HasMiddleware
{

    public static function middleware(){
        return [
            new Middleware('auth', except:['show','index'])
        ];
    }

    public function __invoke()
    {
        //Obtener a quienes seguimos
        $idUsuarios = Auth::user()->followings->pluck('id')->toArray();
        $post = Post::whereIn('user_id', $idUsuarios)->latest()->paginate(5);
        
        return view('home', [
            'posts' => $post
        ]);
    }
}
