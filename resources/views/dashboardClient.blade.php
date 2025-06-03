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
        <div class="link pedidos" :class="section== 'pedidos'? 'active': ''" @click="setSection('pedidos')">Pedidos</div>
    </header>
    <template x-if="section === 'photographers'">    
        <div class="section fotografos" x-data="all_photographers">
            <div class="busqueda">
                    <label for="search" class="search">
                        <input type="text" id="search" placeholder="Nombre del fotógrafo o teléfono" x-ref="search_my_images" @input="filter">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </label>
                    <select x-ref="categoria_my_images" @change="filter">
                        <option selected value="">Ningún filtro</option>
                        <template x-for="(categoria, index) in categorias" :key="index">
                            <option :value="categoria.id" x-text="categoria.nombre"></option>
                        </template>
                    </select>
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
            <div class="close" @click="closeProfile">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 50 50">
<path d="M 7.71875 6.28125 L 6.28125 7.71875 L 23.5625 25 L 6.28125 42.28125 L 7.71875 43.71875 L 25 26.4375 L 42.28125 43.71875 L 43.71875 42.28125 L 26.4375 25 L 43.71875 7.71875 L 42.28125 6.28125 L 25 23.5625 Z"></path>
</svg>
            </div>
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
            <button class="order-button" @click="$store.orderModal.open(photographer)">Pedir productos</button>
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
    <template x-if="section === 'pedidos'">    
        <div class="section pedidos" x-data="pedidosCliente">
            <h2>Mis Pedidos</h2>
            <div class="order-list">
                <template x-for="order in orders" :key="order.id">
                    <div class="order-item">
                        <div class="order-header">
                            <span class="order-id">#<span x-text="order.id"></span></span>
                            <span class="order-photographer">Fotógrafo: <span x-text="order.photographer?.name"></span></span>
                            <span class="order-date" x-text="formatDate(order.created_at)"></span>
                        </div>
                        <div class="order-details">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="item in order.details" :key="item.id">
                                        <tr>
                                            <td x-text="item.name"></td>
                                            <td x-text="formatPrice(item.price)"></td>
                                            <td x-text="item.quantity"></td>
                                            <td x-text="formatPrice(item.price * (item.quantity || 1))"></td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                        <div class="order-footer">
                            <span class="order-total">Total: <span x-text="formatPrice(order.total)"></span></span>
                            <span class="order-status">Estado: <span class="status" x-text="order.status" ></span>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </template>
        <!-- Order Modal (global, outside of templates) -->
        <div x-data x-show="$store.orderModal.show" class="modal-overlay" @click.self="$store.orderModal.close()">
            <div class="modal order-modal">
                <h2>Realizar Pedido a <span x-text="$store.orderModal.photographer?.name"></span></h2>
                <form @submit.prevent="$store.orderModal.submit()">
                    <div class="product-list">
                        <template x-for="product in $store.orderModal.products" :key="product.id">
                            <label class="product-option">
                                <input type="checkbox" :value="product.id" @change="$store.orderModal.toggle(product)"
                                    :checked="$store.orderModal.selected.find(p => p.product.id === product.id) != null">
                                <span x-text="product.name"></span> - <span x-text="product.price"></span> $
                                <template x-if="$store.orderModal.selected.find(p => p.product.id === product.id)">
                                    <input type="number" min="1" style="width:60px;margin-left:8px;" :value="$store.orderModal.selected.find(p => p.product.id === product.id)?.quantity"
                                        @input="$store.orderModal.setQuantity(product, $event.target.value)">
                                </template>
                            </label>
                        </template>
                    </div>
                    <div class="order-total">Total: <span x-text="$store.orderModal.total"></span> $</div>
                    <div class="modal-actions">
                        <button type="submit">Confirmar Pedido</button>
                        <button type="button" @click="$store.orderModal.close()">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
</div>
@endsection
