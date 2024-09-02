<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        //Modificar el Request
        $request->request->add(['username' => Str::slug($request->username)]);

        //Validacion de Campos
        $request->validate([
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:30',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|min:6|confirmed'
        ]);

        //Mandar a llamar el Modelo de User
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password
        ]);

        //Autenticar Usuario
        Auth::attempt($request->only('email','password'));
        

        //Redireccionar al Usuario
        return redirect()->route('post.index',['user' => Auth::user()->username]);
    }
}
