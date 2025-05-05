@extends('layouts.app')

@section('title','Inicio | App Fotógrafos')

@section('content')
<div class="welcome" x-data="main">
    <header>
        <div class="link fotografos" :class="section== 'photographers'? 'active': ''" @click="setSection('photographers')">Fotógrafos</div>
        <div class="link albums" :class="section== 'albums'? 'active': ''" @click="setSection('albums')">Álbums</div>
        <div class="link unete" :class="section== 'register'? 'active': ''" @click="setSection('register')">Únete</div>
        <div class="link login" :class="section== 'login'? 'active': ''" @click="setSection('login')">Iniciar Sesión</div> 
    </header>
    <template x-if="section === 'photographers'">
        <div class="section fotografos">
            <div class="busqueda">
                <label for="search" class="search">
                    <input type="text" id="search" placeholder="Nombre del fotógrafo o teléfono" x-model="searchTerm" @input="filterPhotographers">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </label>
                <select name="categorias" id="categoria">
                    <option value="">Selecciona una categoría</option>
                    <option value="boda">Boda</option>
                    <option value="retrato">Retrato</option>
                    <option value="eventos">Eventos</option>
                    <option value="naturaleza">Naturaleza</option>
                    <option value="comercial">Comercial</option>
                    <option value="social">Social</option>
                    <option value="deportivo">Deportivo</option>
                    <option value="moda">Moda</option>
                </select>
            </div>
        </div>
    </template>
    <template x-if="section === 'albums'">
        <div class="section albums">
            <h1>Álbums</h1>
            <p>Explora nuestros álbumes de fotos.</p>
        </div>
    </template>
    <template x-if="section === 'register'">
        <div class="section unete">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name_" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Phone -->
                <div class="mt-4">
                    <x-input-label for="phone" :value="__('Phone')" />
                    <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autocomplete="tel" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="ms-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Role ID -->
                <input type="hidden" name="role_id" value="2">

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name_photographer" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email_photographer" :value="__('Email')" />
                    <x-text-input id="email_photographer" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Phone -->
                <div class="mt-4">
                    <x-input-label for="phone_photographer" :value="__('Phone')" />
                    <x-text-input id="phone_photographer" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autocomplete="tel" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- Cedula -->
                <div class="mt-4">
                    <x-input-label for="cedula_photographer" :value="__('Cedula')" />
                    <x-text-input id="cedula_photographer" class="block mt-1 w-full" type="text" name="cedula" :value="old('cedula')" autocomplete="cedula" />
                    <x-input-error :messages="$errors->get('cedula')" class="mt-2" />
                </div>

                <!-- Precio Foto -->
                <div class="mt-4">
                    <x-input-label for="precio_foto_photographer" :value="__('Precio por Foto')" />
                    <x-text-input id="precio_foto_photographer" class="block mt-1 w-full" type="number" name="precio_foto" :value="old('precio_foto')" autocomplete="precio_foto" />
                    <x-input-error :messages="$errors->get('precio_foto')" class="mt-2" />
                </div>

                <!-- Certificado -->
                <div class="mt-4">
                    <x-input-label for="certificado_photographer" :value="__('Certificado')" />
                    <x-text-input id="certificado_photographer" class="block mt-1 w-full" type="text" name="certificado" :value="old('certificado')" autocomplete="certificado" />
                    <x-input-error :messages="$errors->get('certificado')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password_photographer" :value="__('Password')" />
                    <x-text-input id="password_photographer" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation_photographer" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation_photographer" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="ms-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </template>
    <template x-if="section === 'login'">
        <div class="section login">
            <form method="POST" action="{{ route('login') }}">
                @csrf
        
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
        
                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
        
                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />
        
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
        
                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>
        
                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
        
                    <x-primary-button class="ms-3">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </template>
</div>
@endsection