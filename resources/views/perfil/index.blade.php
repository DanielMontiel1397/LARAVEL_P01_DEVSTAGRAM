@extends('layouts.app')

@section('titulo')
    Editar Perfil: {{auth()->user()->username}}
@endsection

@section('contenido')
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white shadow p-6">
            <form action="{{route('perfil.store')}}" class="mt-10 md:mt-0" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-5">
                    <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">
                        Username
                    </label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        placeholder="Tú Nombre de Usuario..." 
                        class="border p-3 w-full rounded-lg @error('username') border-red-500 @enderror"
                        value="{{auth()->user()->username}}">

                    @error('username')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">
                        Email
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="Tú Email de Usuario..." 
                        class="border p-3 w-full rounded-lg @error('username') border-red-500 @enderror"
                        value="{{auth()->user()->email}}">

                    @error('email')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">
                        Foto de Perfil
                    </label>
                    <input 
                        type="file" 
                        id="imagen" 
                        name="imagen" 
                        class="border p-3 w-full rounded-lg"
                        value=""
                        accept=".jpg .jpeg .png"
                    >
                </div>

                <div class="mb-5">
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">
                        Ingresa tú password para poder hacer los cambios
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Tú Password de Registro..." 
                        class="border p-3 w-full rounded-lg @if(session('mensaje'))('password') border-red-500 @endif"
                    >
                    @if(session('mensaje'))
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{session('mensaje')}}
                        </p>
                    @endif
                </div>

                <input type="submit" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white uppercase rounded-lg" value="Guardar Cambios">
            </form>

        </div>
    </div>
@endsection