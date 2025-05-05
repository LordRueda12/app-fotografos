@extends('layouts.app')

@section('title','Inicio | App Fotógrafos')

@section('content')
<div class="dashboard" x-data="main">
    <header>
        <div class="link fotografos" :class="section== 'photographers'? 'active': ''" @click="setSection('photographers')">Fotógrafos</div>
        <div class="link albums" :class="section== 'albums'? 'active': ''" @click="setSection('albums')">Álbums</div>
        <div class="link subir-imagen" :class="section== 'upload'? 'active': ''" @click="setSection('upload')">Subir imágenes</div>
        <div class="link mis-imagenes" :class="section== 'myImages'? 'active': ''" @click="setSection('myImages')">Mis imágenes</div>
    </header>
    <template x-if="section === 'photographers'">
        <div class="section fotografos" x-data="photographers">
            <div class="busqueda">
                <label for="search" class="search">
                    <input type="text" id="search" placeholder="Nombre del fotógrafo o teléfono" >
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
    <template x-if="section === 'albums'">
        <div class="section albums">
            <h2>Álbums</h2>
            <p>Contenido de la sección de álbumes.</p>
        </div>
    </template>
    <template x-if="section === 'upload'">
        <div class="section upload" x-data="upload">
            <h2>Subir imágenes</h2>
            
            <form action="/upload" method="POST" enctype="multipart/form-data" @submit.prevent="uploadImage">
                @csrf
                <input type="file" name="ruta" x-ref="ruta_upload_image" accept="image/*" @change="previewImage">
                <div class="image-preview" x-show="imagePreview">
                    <img :src="imagePreview" alt="Vista previa de la imagen" style="max-width: 300px; max-height: 300px;">
                </div>
                <input type="text" name="titulo" x-ref="titulo_upload_image" placeholder="Título de la imagen">
                <select name="categoria_id" x-ref="categoria_upload_image">
                    <template x-for="(categoria, index) in categorias" :key="index">
                        <option :value="categoria.id" x-text="categoria.nombre"></option>
                    </template>
                </select>
                <button type="submit">Subir</button>
            </form>
        </div>
    </template>
</div>
@endsection