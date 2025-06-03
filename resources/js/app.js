import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.data('pedidosCliente', () => ({
    orders: [],
    init(){
        this.fetchOrders();
    },
    fetchOrders(){
        fetch(`http://localhost:8000/api/ordenes?client_id=${user.id}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            this.orders = data;
            console.log(this.orders);
        })
        .catch(error => console.error('Error:', error));
    }
}));
Alpine.data('albums', () => ({
    albumList: {},
    showModal: false,
    modalImages: [],
    openModal(images) { this.modalImages = images; this.showModal = true; },
    closeModal() { this.showModal = false; this.modalImages = []; },
    init() {
        this.fetchAlbums();
    },
    fetchAlbums() {
        fetch(`http://localhost:8000/api/imagenes/usuario/${user.id}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            this.images = data;
            this.pages = [];
            const albumsByCategory = {};
            data.forEach(img => {
                const catName = img.categoria?.nombre || (img.categoria_nombre || 'Sin categoría');
                if (!albumsByCategory[catName]) {
                    albumsByCategory[catName] = [];
                }
                albumsByCategory[catName].push(img);
            });
            this.albumList = Object.values(albumsByCategory); // Array of arrays, each array is images in a category
            console.log(this.albumList);
        })
        .catch(error => console.error('Error:', error));
    }

}))
Alpine.data('main', () => ({
    categorias: [],
    section: 'welcome',
    photographer: null,
    routes: {
        "register": "unete",
        "login": "iniciar-sesion",
        "photographers": "fotografos",
        "albums": "albumes",
    },
    inversedRoutes: {
        "/unete": "register",
        "/iniciar-sesion": "login",
        "/fotografos": "photographers",
        "/albumes": "albums",
    },
    fetchCategories() {
        fetch('http://localhost:8000/api/categorias', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            this.categorias = data; 
        })
        .catch(error => console.error('Error:', error));
    },
    init() {
        this.fetchCategories();
    },
    setSection(section) {
        this.section = section;
        window.history.pushState({}, '', this.routes[section]);
    },
    closeProfile(){
        this.photographer = null;
    },
    formatDate(date){
        const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
        return new Date(date).toLocaleDateString('es-ES', options);
    },
    formatPrice(price){
        return new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(price);
    },
    normalize(str){
        return str.normalize('NFD').replace(/[\u0300-\u036f]/g, "").toLowerCase();
    }
}));
Alpine.data('all_photographers', () => ({
    originalImages: [],
    images: [],
    pages: [],
    init() {
        this.fetchImages();
    },
    fetchImages() {
        fetch('http://localhost:8000/api/imagenes', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            this.originalImages = data;
            this.images = data;
            this.pages = [];
            for (let i = 0; i < data.length; i += 6) {
                this.pages.push(data.slice(i, i + 6));
            }
            window.pages = this.pages;
        })
        .catch(error => console.error('Error:', error));
    },
    filter() {
        const selectedCategory = this.$refs.categoria_my_images.value;
        const searchQuery = this.normalize(this.$refs.search_my_images.value.toLowerCase());
        let filtered = this.originalImages;
        if (selectedCategory !== '') {
            filtered = filtered.filter(image => image.categoria_id == selectedCategory);
        }
        if (searchQuery) {
            filtered = filtered.filter(image =>
                image.nombre && this.normalize(image.nombre.toLowerCase()).includes(searchQuery)
            );
        }
        this.images = filtered;
        this.pages = [];
        for (let i = 0; i < this.images.length; i += 6) {
            this.pages.push(this.images.slice(i, i + 6));
        }
    },
}));
Alpine.data('myImages', () => ({
    originalImages: [],
    images: [],
    pages: [],
    init() {
        this.fetchImages();
    },
    fetchImages() {
        fetch(`http://localhost:8000/api/imagenes/usuario/${user.id}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            this.originalImages = data;
            this.images = data;
            this.pages = [];
            for (let i = 0; i < data.length; i += 6) {
                this.pages.push(data.slice(i, i + 6));
            }
            window.pages = this.pages;
        })
        .catch(error => console.error('Error:', error));
    },
    filter() {
        const selectedCategory = this.$refs.categoria_my_images.value;
        const searchQuery = this.normalize(this.$refs.search_my_images.value.toLowerCase());
        let filtered = this.originalImages;
        if (selectedCategory !== '') {
            filtered = filtered.filter(image => image.categoria_id == selectedCategory);
        }
        if (searchQuery) {
            filtered = filtered.filter(image =>
                image.nombre && this.normalize(image.nombre.toLowerCase()).includes(searchQuery)
            );
        }
        this.images = filtered;
        this.pages = [];
        for (let i = 0; i < this.images.length; i += 6) {
            this.pages.push(this.images.slice(i, i + 6));
        }
    },
}));
Alpine.data('photographers', () => ({
    photographers: null,
    active: 0,
    activeAnimation: 0,
    showOrderModal: false,
    selectedPhotographer: null,
    photographerProducts: [],
    selectedProducts: [],
    orderTotal: 0,
    init(){
        this.fetchPhotographers();
    },
    fetchPhotographers() {
        
        fetch('http://localhost:8000/api/photographers', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            this.photographers = data;
        })
        .catch(error => console.error('Error:', error));
    },
    openOrderModal(photographer) {
        this.selectedPhotographer = photographer;
        this.selectedProducts = [];
        this.orderTotal = 0;
        // Fetch products for this photographer
        fetch(`/api/productos?photographer_id=${photographer.id}`)
            .then(res => res.json())
            .then(products => {
                this.photographerProducts = products.filter(p => p.photographer_id === photographer.id);
                this.showOrderModal = true;
            });
    },
    closeOrderModal() {
        this.showOrderModal = false;
        this.selectedPhotographer = null;
        this.photographerProducts = [];
        this.selectedProducts = [];
        this.orderTotal = 0;
    },
    toggleProductSelection(product) {
        const idx = this.selectedProducts.findIndex(p => p.id === product.id);
        if (idx > -1) {
            this.selectedProducts.splice(idx, 1);
        } else {
            this.selectedProducts.push(product);
        }
        this.calculateOrderTotal();
    },
    calculateOrderTotal() {
        this.orderTotal = this.selectedProducts.reduce((sum, p) => sum + Number(p.price), 0);
    },
    submitOrder() {
        if (!this.selectedPhotographer || this.selectedProducts.length === 0) {
            alert('Selecciona al menos un producto.');
            return;
        }
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch('/api/ordenes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({
                photographer_id: this.selectedPhotographer.id,
                details: this.selectedProducts.map(p => ({ id: p.id, name: p.name, price: p.price })),
                total: this.orderTotal,
                status: 'pendiente',
            })
        })
        .then(res => res.json())
        .then(data => {
            alert('Pedido realizado con éxito');
            this.closeOrderModal();
        })
        .catch(err => {
            alert('Error al realizar el pedido');
            console.error(err);
        });
    },
    nextPhotographer(){
        this.activeAnimation= 1;
        setTimeout(() => {
            this.active= (this.active + 1) % this.photographers.length;
            this.activeAnimation = 0;
        }, 1000);
    },
    prevPhotographer(){
        this.activeAnimation= -1;
        setTimeout(() => {
            this.active= (this.active - 1 + this.photographers.length) % this.photographers.length;
            this.activeAnimation = 0;
        }, 1000);
    },
    openProfile(photographer){
        this.photographer = photographer;
        this.photographer.pages= [];
        for (let i = 0; i < photographer.imagenes.length; i += 6) {
            this.photographer.pages.push(photographer.imagenes.slice(i, i + 6));
        }
    }
}))
Alpine.data('upload', () => ({
    imagePreview: null,
    previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            this.imagePreview = URL.createObjectURL(file);
        }
    },
    uploadImage() {
        const fileInput = this.$refs.ruta_upload_image;
        const titleInput = this.$refs.titulo_upload_image;
        const nombreInput = this.$refs.titulo_upload_image;
        const categorySelect = this.$refs.categoria_upload_image;

        if (!fileInput.files[0]) {
            alert('Por favor selecciona una imagen.');
            return;
        }
        if (!nombreInput.value) {
            alert('Por favor ingresa el nombre de la imagen.');
            return;
        }

        const file = fileInput.files[0];
        const formData = new FormData();
        formData.append('ruta', file);
        formData.append('titulo', titleInput.value);
        formData.append('nombre', nombreInput.value); // Use input value for nombre
        formData.append('categoria_id', categorySelect.value);
        formData.append('user_id', user.id);

        fetch('http://localhost:8000/api/imagenes', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            console.log('Imagen subida:', data);
            alert('Imagen subida exitosamente.');
            this.imagePreview = null;
            fileInput.value = '';
            titleInput.value = '';
            nombreInput.value = '';
            categorySelect.value = '';
        })
        .catch(error => console.error('Error al subir la imagen:', error));
    },
}));
Alpine.data('photographerProfile', () => ({
    notifications: [],
    orders: [],
    products: [],
    showNewProductModal: false,
    showOrderDetailsModal: false,
    selectedOrder: null,
    balance: 0,
    async init() {
        await this.fetchProducts();
        await this.fetchOrders();
        this.calculateBalance()
    },
    
    async fetchOrders(){
        await fetch(`/api/ordenes?photographer_id=${user.id}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            this.orders = data;
            console.log(this.orders);
        })
        .catch(error => console.error('Error fetching orders:', error));
    },
    async fetchProducts() {
        const id = this.photographerId || (typeof user !== 'undefined' ? user.id : null);
        if (!id) return;
        await fetch(`/api/productos?photographer_id=${id}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            this.products = data;
            console.log(this.products);
        })
        .catch(error => console.error('Error fetching products:', error));
    },
    calculateBalance() {
        let total = 0;
        this.orders.forEach((order) => {
            if (['pagada', 'completada'].includes(order.status)) {
                total += order.total;
            }
        });
        this.balance = total;
    },
    openModal(modal) {
        if (modal === 'newProduct') {
            this.showNewProductModal = true;
        }
    },
    closeModal(modal) {
        if (modal === 'newProduct') {
            this.showNewProductModal = false;
            this.resetNewProduct();
        }
    },
    resetNewProduct() {
        if (this.$refs && this.$refs.product_name) {
            this.$refs.product_name.value = '';
            this.$refs.product_description.value = '';
            this.$refs.product_price.value = '';
            if (this.$refs.product_image) this.$refs.product_image.value = '';
        }
    },
    submitNewProduct() {
        const name = this.$refs.product_name.value;
        const description = this.$refs.product_description.value;
        const price = this.$refs.product_price.value;
        const imageFile = this.$refs.product_image.files[0];
        if (!name || !description || !price) {
            alert('Por favor completa todos los campos obligatorios.');
            return;
        }
        const formData = new FormData();
        formData.append('name', name);
        formData.append('description', description);
        formData.append('price', price);
        if (imageFile) {
            formData.append('image', imageFile);
        }
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        fetch('/api/productos', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            alert('Producto creado exitosamente');
            this.closeModal('newProduct');
            this.fetchProducts(); // Refresh products after creation
        })
        .catch(error => {
            alert('Error al crear el producto');
            console.error(error);
        });
    },
    showOrderDetails(index) {
        this.selectedOrder = this.orders[index];
        this.showOrderDetailsModal = true;
    },
    closeOrderDetailsModal() {
        this.showOrderDetailsModal = false;
        this.selectedOrder = null;
    },
    updateOrderStatus(order, newStatus) {
        if (order.status === newStatus) return;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch(`/api/ordenes/${order.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(res => res.json())
        .then(data => {
            order.status = newStatus;
            this.$nextTick(()=>{
                this.calculateBalance()
            })

        })
        .catch(err => {
            alert('Error al actualizar el estado');
            console.error(err);
        });
    },
}));

// Alpine store for order modal
Alpine.store('orderModal', {
    show: false,
    photographer: null,
    products: [],
    selected: [], // [{product, quantity}]
    total: 0,
    open(photographer) {
        this.photographer = photographer;
        this.selected = [];
        this.total = 0;
        fetch(`/api/productos?photographer_id=${photographer.id}`)
            .then(res => res.json())
            .then(products => {
                this.products = products.filter(p => p.photographer_id === photographer.id);
                this.show = true;
            });
    },
    close() {
        this.show = false;
        this.photographer = null;
        this.products = [];
        this.selected = [];
        this.total = 0;
    },
    toggle(product) {
        const idx = this.selected.findIndex(p => p.product.id === product.id);
        if (idx > -1) {
            this.selected.splice(idx, 1);
        } else {
            this.selected.push({ product, quantity: 1 });
        }
        this.calculate();
    },
    setQuantity(product, quantity) {
        const idx = this.selected.findIndex(p => p.product.id === product.id);
        if (idx > -1) {
            this.selected[idx].quantity = Math.max(1, Number(quantity));
            this.calculate();
        }
    },
    calculate() {
        this.total = this.selected.reduce((sum, p) => sum + Number(p.product.price) * p.quantity, 0);
    },
    submit() {
        if (!this.photographer || this.selected.length === 0) {
            alert('Selecciona al menos un producto.');
            return;
        }
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch('/api/ordenes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({
                photographer_id: this.photographer.id,
                details: this.selected.map(p => ({ id: p.product.id, name: p.product.name, price: p.product.price, quantity: p.quantity })),
                total: this.total,
                status: 'pendiente',
            })
        })
        .then(res => res.json())
        .then(data => {
            alert('Pedido realizado con éxito');
            this.close();
        })
        .catch(err => {
            alert('Error al realizar el pedido');
            console.error(err);
        });
    }
});

Alpine.start();
