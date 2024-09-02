<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;

use Illuminate\Routing\Controllers\Middleware;
use Intervention\Image\Drivers\Imagick\Driver;
use Illuminate\Routing\Controllers\HasMiddleware;

class PerfilController extends Controller implements HasMiddleware
{

    public static function middleware(){
        return [
            new Middleware('auth', except:['show','index'])
        ];
    }

    public function index(){
        return view('perfil.index');
    }
    public function store(Request $request){

        $request->request->add(['username' => Str::slug($request->username)]);

        //Validar la información
        $request->validate([
            'username' => ['required','unique:users,username,'.Auth::user()->id,'min:3','max:20','not_in:twitter,editar-perfil'],
            'email' => ['required', 'email', 'max:60', 'unique:users,email,'.Auth::user()->id]
        ]);
        if(!Hash::check($request->password, Auth::user()->password)){
            return back()->with('mensaje','Password Incorrecto');
        }
        
        if($request->imagen){
            $imagen = $request->file('imagen');
            
            $nombreImagen = Str::uuid() . "." . $imagen->extension();
            
            $manager = new ImageManager(new Driver());

            $imagenServidor = $manager::imagick()->read($imagen);
            $imagenServidor->cover(1000,1000);
    
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
    
            $imagenServidor->save($imagenPath);
        }

        //Guardar Cambios
        $usuario = User::find(Auth::user()->id);

        $usuario->username = $request->username;
        $usuario->email = $request->email;
        $usuario->imagen = $nombreImagen ?? Auth::user()->imagen ?? null;
        $usuario->save();

        //Redireccionar
        return redirect()->route('post.index', $usuario->username);
    }
}
