@extends('layouts.app')

@section('title','Inicio | App Fotógrafos')

<head>
    @vite(['resources/css/dashboardClient.css'])
</head>

@section('content')
<div class="dashboard" x-data="main">
    <header>
        <div class="link inicio" :class="section== 'welcome'? 'active': ''" @click="setSection('welcome')">Inicio</div>
        <div class="link fotografos" :class="section== 'photographers'? 'active': ''" @click="setSection('photographers')">Fotógrafos</div>
    </header>
    <template x-if="section === 'photographers'">    
        <div class="section fotografos" x-data="all_photographers">
            <div class="busqueda">
                <label for="search" class="search">
                    <input type="text" id="search" placeholder="Nombre del fotógrafo o teléfono" >
                    <i class="fa-solid fa-magnifying-glass"></i>
                </label>
                <select x-ref="categoria_photographers" @change="filterByCategory">
                    <option selected value= "">Ningún filtro</option>
                    <template x-for="(categoria, index) in categorias" :key="index">
                        <option :value="categoria.id" x-text="categoria.nombre"></option>
                    </template>
                </select>
            </div>
            <div class="card-container">
                <div class="card">Impresiones Fotográficas</div>
                <div class="card">Servicio Digital</div>
                <div class="card">Retrato</div>
                <div class="card">Combos</div>
            </div>
            <template x-for="(page, index) in pages" :key="index">
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
        </div>
    </template>
    <template x-if="photographer != null">
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
</div>
@endsection
