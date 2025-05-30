@extends('layouts.app')

@section('title','Inicio | App Fotógrafos')

@section('content')
@vite(['resources/css/welcome.css'])
<div class="welcome" x-data="main">
    <header>
        <div class="link inicio" :class="section== 'welcome'? 'active': ''" @click="setSection('welcome')">Inicio</div>
        <div class="link unete" :class="section== 'register-client'? 'active': ''" @click="setSection('register-client')">Únete Cliente</div>
        <div class="link unete" :class="section== 'register-photographer'? 'active': ''" @click="setSection('register-photographer')">Únete Fotografo</div>
        <div class="link login" :class="section== 'login'? 'active': ''" @click="setSection('login')">Iniciar Sesión</div> 
    </header>
    <template x-if="!!photographer">
        <div class="fotografo">
            <div class="close" @click="closeProfile">✖️</div>
            <div class="fotografo-header">
                <div class="left">
                    <figure class="profile-pic">
                        <img :src="`/storage/${photographer.profile_image}`" alt="User Image">
                    </figure>
                </div>
                <div class="right">
                    <div class="fotografo-name" x-text="photographer.name"></div>
                    <div class="fotografo-description" x-text="photographer.description"></div>
                </div>
            </div>
            <div class="card-container">
                <div class="card">Impresiones Fotográficas</div>
                <div class="card">Servicio Digital</div>
                <div class="card">Retrato</div>
                <div class="card">Combos</div>
            </div>
            <template x-for="(page, index) in photographer.pages" :key="index">
            <div class="picture-container">
                <template x-if="page[0]">
                    <div class="small-picture1">
                        <img :src="`/storage/${page[0].ruta}`" alt="">
                    </div>
                </template>
                <template x-if="page[1]">
                    <div class="small-picture2">
                        <img :src="`/storage/${page[1].ruta}`" alt="">
                    </div>
                </template>
                <template x-if="page[2]">
                    <div class="large-picture1">
                        <img :src="`/storage/${page[2].ruta}`" alt="">
                    </div>
                </template>

                <!-- Second layout: One big picture above two small pictures -->
                <template x-if="page[3]">
                    <div class="large-picture2">
                        <img :src="`/storage/${page[3].ruta}`" alt="">
                    </div>
                </template>
                <template x-if="page[4]">
                    <div class="small-picture3">
                        <img :src="`/storage/${page[4].ruta}`" alt="">
                    </div>
                </template>
                <template x-if="page[5]">
                    <div class="small-picture4">
                        <img :src="`/storage/${page[5].ruta}`" alt="">
                    </div>
                </template>
            </div>
            </template>
            <button class="contact-button">Contactar</button>
        </div>
    </template>
    <template x-if="section === 'welcome'">
        <div class="section welcome" x-data="photographers">
            <div class="name-section" x-text="photographers[active].name">
            </div>
            <div class="description-section" x-text="photographers[active].description">
            </div>
            <div class="button-section">
                <button class="contact-button">Contactar</button>
                <button class="profile-button" @click="openProfile(photographers[active])">Perfil</button>
            </div>
            <template x-if="!photographer">
                
            </template>
            <template x-if="photographers.length > 0">
                <div class="image-circle" :class="[activeAnimation== 0? 'passed': activeAnimation== -1?'active': 'hidden', !activeAnimation?'dontAnimate': '']">
                    <img :src="`/storage/${photographers[(active - 1 + photographers.length) % photographers.length].profile_image}`" alt="User Image">
                </div>
            </template>
            <template x-if="photographers.length > 0">
                <div class="image-circle" :class="[activeAnimation== 0? 'active': activeAnimation== -1?'': 'passed', !activeAnimation?'dontAnimate': '']">
                    <img :src="`/storage/${photographers[active % photographers.length].profile_image}`" alt="User Image">
                </div>
            </template>
            <template x-if="photographers.length > 0">
                <div class="image-circle" :class="[activeAnimation== 0? '': activeAnimation== -1?'previous':'active', !activeAnimation?'dontAnimate': '']">
                    <img :src="`/storage/${photographers[(active + 1) % photographers.length].profile_image}`" alt="User Image">
                </div>
            </template>
            <template x-if="photographers.length > 0">
                <div class="image-circle" :class="[activeAnimation== 0? 'previous': activeAnimation== -1?'hidden':'', !activeAnimation?'dontAnimate': '']">
                    <img :src="`/storage/${photographers[(active + 2) % photographers.length].profile_image}`" alt="User Image">
                </div>
            </template>
            <template x-if="photographers.length > 0">
                <div class="image-circle" :class="[activeAnimation== 0? 'hidden': activeAnimation== -1?'passed':'previous', !activeAnimation?'dontAnimate': '']">
                    <img :src="`/storage/${photographers[(active + 3) % photographers.length].profile_image}`" alt="User Image">
                </div>
            </template>
            <div class="navigation-buttons">
                <button class="prev-button" @click="prevPhotographer">&lt;</button>
                <button class="next-button" @click="nextPhotographer">&gt;</button>
            </div>
        </div>
        </template>
    <template x-if="section === 'photographers'">
        <div class="section fotografos section">
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
        <div class="section albums section">
            <h1>Álbums</h1>
            <p>Explora nuestros álbumes de fotos.</p>
        </div>
    </template>
    <template x-if="section === 'register-client'">
        <div class="section unete section">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="hidden" name="role_id" value="3">

                <!-- Name -->
                <div>
                    <x-input-label for="name_" :value="__('Nombre')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Phone -->
                <div>
                    <x-input-label for="phone" :value="__('Celular')" />
                    <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autocomplete="tel" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Contraseña')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />
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
            
        </div>
    </template>
    <template x-if="section === 'register-photographer'">
        <div class="section unete">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Role ID -->
                <input type="hidden" name="role_id" value="2">

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Nombre')" />
                    <x-text-input id="name_photographer" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email_photographer" :value="__('Email')" />
                    <x-text-input id="email_photographer" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Phone -->
                <div>
                    <x-input-label for="phone_photographer" :value="__('Celular')" />
                    <x-text-input id="phone_photographer" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autocomplete="tel" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- Cedula -->
                <div>
                    <x-input-label for="cedula_photographer" :value="__('Cédula')" />
                    <x-text-input id="cedula_photographer" class="block mt-1 w-full" type="text" name="cedula" :value="old('cedula')" autocomplete="cedula" />
                    <x-input-error :messages="$errors->get('cedula')" class="mt-2" />
                </div>


                <!-- Password -->
                <div>
                    <x-input-label for="password_photographer" :value="__('Contraseña')" />
                    <x-text-input id="password_photographer" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation_photographer" :value="__('Confirmar contraseña')" />
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
        <div class="section login section">
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