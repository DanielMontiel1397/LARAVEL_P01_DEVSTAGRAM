<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\HomeController;

Route::get('/', HomeController::class)->name('home');

//Routing para crear cuanta
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

//routing para iniciar sesión
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout',[LogoutController::class, 'store'])->name('logout');

//Routing para editar Perfil
Route::get('/editar-perfil', [PerfilController::class, 'index'])->name('perfil.index');
Route::post('/editar-perfil', [PerfilController::class, 'store'])->name('perfil.store');

//routing para muro de usuario
Route::get('/{user:username}',[PostController::class, 'index'])->name('post.index');
Route::get('/posts/create',[PostController::class, 'create'])->name('post.create');
Route::post('/posts',[PostController::class, 'store'])->name('post.store');

//routing para mostrar una publicacion
Route::get('/{user:username}/posts/{post}',[PostController::class, 'show'])->name('post.show');

//Route para almacenar imagen de publicación.
Route::post('/imagenes',[ImagenController::class, 'store'])->name('imagenes.store');

//Routing eliminar post
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('post.destroy');

//Routing para registrar comentarios
Route::post('/{user:username}/posts/{post}',[ComentarioController::class, 'store'])->name('comentarios.store');

//Routing para dar like a las fotos
Route::post('/posts/{post}/likes', [LikeController::class, 'store'])->name('post.likes.store');

Route::delete('/posts/{post}/likes', [LikeController::class, 'destroy'])->name('post.likes.destroy');

//Routing para seguir usuarios
Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->name('user.follow');
Route::delete('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->name('user.unfollow');
