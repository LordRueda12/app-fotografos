@extends('layouts.app')

@section('title', 'Inicio | App Fotógrafos')

@section('content')
    <script>
        const user = @json(Auth::user());
    </script>
    <div class="dashboard" x-data="main">
        <header x-init="section= 'profile'">
            <div class="link perfil" :class="section == 'profile' ? 'active' : ''" @click="setSection('profile')">Perfil</div>
            <div class="link albums" :class="section == 'albums' ? 'active' : ''" @click="setSection('albums')">Álbums</div>
            <div class="link subir-imagen" :class="section == 'upload' ? 'active' : ''" @click="setSection('upload')">Subir
                imágenes</div>
            <div class="link mis-imagenes" :class="section == 'myImages' ? 'active' : ''" @click="setSection('myImages')">Mis
                imágenes</div>
        </header>
        <template x-if="section === 'profile'">
            <div class="profile-dashboard" x-data="photographerProfile">
                <!-- New Product Modal -->
                <div x-show="showNewProductModal" class="modal-overlay" @click.self="closeModal('newProduct')">
                    <div class="modal new-product-modal">
                        <h2>Nuevo Producto</h2>
                        <form @submit.prevent="submitNewProduct" enctype="multipart/form-data">
                            <label>Nombre</label>
                            <input type="text" x-ref="product_name" required>
                            <label>Descripción</label>
                            <textarea x-ref="product_description" required></textarea>
                            <label>Precio</label>
                            <input type="number" x-ref="product_price" min="0" required>
                            <label>Imagen</label>
                            <input type="file" x-ref="product_image" accept="image/*">
                            <div class="modal-actions">
                                <button type="submit">Guardar</button>
                                <button type="button" @click="closeModal('newProduct')">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <section class="balance">
                    <h2>Balance</h2>
                    <h1 class="ordenesPagas" x-text="formatPrice(balance)"></h1>
                </section>
                <section class="quick-actions">
                    <div class="action" @click="openModal('newProduct')">
                        <i class="fa-solid fa-plus"></i>
                        <span>Nuevo producto</span>
                    </div>
                </section>
                <section class="orders">
                    <h2>Órdenes</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(order, index) in orders" :key="index" >
                            <tr @click="showOrderDetails(index)">
                                <td x-text="order.id"></td>
                                <td x-text="order.client.name"></td>
                                <td x-text="formatDate(order.created_at)"></td>
                                <td x-text="formatPrice(order.total)"></td>
                                <td>
                                    <select :value="order.status" @click.stop @change="updateOrderStatus(order, $event.target.value)">
                                        <option value="pendiente">Pendiente</option>
                                        <option value="confirmada">Confirmada</option>
                                        <option value="pagada">Pagada</option>
                                        <option value="completada">Completada</option>
                                        <option value="cancelada">Cancelada</option>
                                    </select>
                                </td>
                            </tr>
                            </template>
                        </tbody>
                    </table>
                    <!-- Order Details Modal -->
                    <div x-show="showOrderDetailsModal" class="modal-overlay" @click.self="closeOrderDetailsModal()">
                        <div class="modal order-details-modal">
                            <h2>Detalles del Pedido</h2>
                            <template x-if="selectedOrder">
                                <div>
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
                                            <template x-for="item in selectedOrder.details" :key="item.id">
                                                <tr>
                                                    <td x-text="item.name"></td>
                                                    <td x-text="formatPrice(item.price)"></td>
                                                    <td x-text="item.quantity"></td>
                                                    <td x-text="formatPrice(item.price * item.quantity)"></td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th colspan="2">Datos del cliente</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <tr>
                                            <td>Nombre</td>
                                            <td x-text="selectedOrder.client.name"></td>
                                           </tr>
                                           
                                           <tr>
                                            <td>Celular</td>
                                            <td x-text="selectedOrder.client.phone"></td>
                                           </tr>
                
                                           <tr>
                                            <td>Correo</td>
                                            <td x-text="selectedOrder.client.email"></td>
                                           </tr>
                                           
                                        </tbody>
                                    </table>

                                    <div style="margin-top:1em; font-weight:bold;">Total: <span x-text="formatPrice(selectedOrder.total)"></span></div>
                                </div>
                            </template>
                            <div class="modal-actions">
                                <button type="button" @click="closeOrderDetailsModal()">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Products Table -->
                <section class="products">
                    <h2>Mis Productos</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Imagen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(product, index) in products" :key="product.id">
                                <tr>
                                    <td x-text="product.name"></td>
                                    <td x-text="product.description"></td>
                                    <td x-text="product.price"></td>
                                    <td>
                                        <img x-show="product.image" :src="'/storage/' + product.image" alt="Imagen del producto" style="max-width: 80px; max-height: 80px;">
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </section>
            </div>
        </template>
        <template x-if="section === 'photographers'">
            <div class="section fotografos" x-data="all-photographers">
                <div class="busqueda">
                    <label for="search" class="search">
                        <input type="text" id="search" placeholder="Nombre del fotógrafo o teléfono">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </label>
                    <select x-ref="categoria_photographers" @change="filterByCategory">
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
        <template x-if="section === 'albums'">
            <div class="section albums" x-data="albums" x-init="albums = $store.albums?.albums || []">
                <h2 class="albumsTitulo">Álbums</h2>
                <template x-for="(album, index) in albumList" :key="index">
                    <div class="album">
                        <template x-if="album.length && album[0].categoria">
                            <h3 x-text="album[0].categoria.nombre" style="cursor:pointer" @click="openModal(album)"></h3>
                        </template>
                        <div class="images">
                            <template x-for="image in album.slice(-4)" :key="image.id">
                                <img :src="`/storage/${image.ruta}`" alt="" style="max-width: 100px; max-height: 100px;">
                            </template>
                        </div>
                    </div>
                </template>
                <div x-show="showModal" class="modal-overlay" style="z-index:2000;" @click.self="closeModal()">
                    <div class="modal" style="background:#222;padding:2em;max-width:90vw;max-height:90vh;overflow:auto;border-radius:12px;">
                        <h2 style="color:#fff;">Todas las imágenes</h2>
                        <div style="display:flex;flex-wrap:wrap;gap:16px;justify-content:center;">
                            <template x-for="image in modalImages" :key="image.id">
                                <img :src="`/storage/${image.ruta}`" alt="" style="max-width:180px;max-height:180px;border-radius:8px;box-shadow:0 2px 8px #0003;">
                            </template>
                        </div>
                        <button @click="closeModal()" style="margin-top:2em;padding:0.5em 1.5em;background:#fff;color:#222;border:none;border-radius:6px;cursor:pointer;">Cerrar</button>
                    </div>
                </div>
            </div>
        </template>
        <template x-if="section === 'upload'">
            <div class="section upload" x-data="upload">

                <form action="/upload" method="POST" enctype="multipart/form-data" @submit.prevent="uploadImage">
                    @csrf
                    <input type="file" name="ruta" x-ref="ruta_upload_image" accept="image/*" @change="previewImage">
                    <div class="image-preview" x-show="imagePreview">
                        <img :src="imagePreview" alt="Vista previa de la imagen"
                            style="max-width: 300px; max-height: 300px;">
                    </div>
                    <input type="text" name="titulo" x-ref="titulo_upload_image" placeholder="Título de la imagen">
                    <select name="categoria_id" x-ref="categoria_upload_image">
                        <option selected disable hidden>Selecciona una categoría</option>
                        <template x-for="(categoria, index) in categorias" :key="index">
                            <option :value="categoria.id" x-text="categoria.nombre"></option>
                        </template>
                    </select>
                    <button type="submit">Subir</button>
                </form>
            </div>
        </template>
        <template x-if="section === 'myImages'">
            <div class="section mis-imagenes" x-data="myImages">
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
                        <div class="small-picture1">
                            <img :src="`/storage/${page[0].ruta}`" alt="">
                        </div>
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
    </div>
@endsection
