import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

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
    filterByCategory() {
        const selectedCategory = this.$refs.categoria_photographers.value;
        if (selectedCategory === '') {
            this.images = this.originalImages;
        } else {
            this.images = this.originalImages.filter(image => image.categoria_id == selectedCategory);
        }
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
    filterByCategory() {
        const selectedCategory = this.$refs.categoria_my_images.value;
        if (selectedCategory === '') {
            this.images = this.originalImages;
        } else {
            this.images = this.originalImages.filter(image => image.categoria_id == selectedCategory);
        }
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
        const categorySelect = this.$refs.categoria_upload_image;

        if (!fileInput.files[0]) {
            alert('Por favor selecciona una imagen.');
            return;
        }

        const formData = new FormData();
        formData.append('ruta', fileInput.files[0]);
        formData.append('titulo', titleInput.value);
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
            categorySelect.value = '';
        })
        .catch(error => console.error('Error al subir la imagen:', error));
    },
}));
Alpine.data('photographerProfile', () => ({
    notifications: [],
    orders: [],
    showNewProductModal: false,
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
        fetch('/api/productos', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            alert('Producto creado exitosamente');
            this.closeModal('newProduct');
        })
        .catch(error => {
            alert('Error al crear el producto');
            console.error(error);
        });
    },
}));

Alpine.start();
