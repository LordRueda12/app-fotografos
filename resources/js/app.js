import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('main', () => ({
    section: 'register',
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
    init() {
        const path = window.location.pathname;
        const section = this.inversedRoutes[path] || 'register';
        this.section = section;
        this.setSection(section);
    },
    setSection(section) {
        this.section = section;
        window.history.pushState({}, '', this.routes[section]);
    }
}))
Alpine.data('photographers', () => ({
    images: [],
    pages: [],
    init() {
        this.fetchImages();
    },
    fetchImages(){
        fetch('http://localhost:8000/api/imagenes', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            this.images = data;
            this.pages = [];
            for (let i = 0; i < data.length; i += 6) {
                this.pages.push(data.slice(i, i + 6));
            }
            window.pages= this.pages;

        })
        .catch(error => console.error('Error:', error));
    }
}))
Alpine.data('upload', () => ({
    categorias: [],
    imagePreview: null, // Holds the image preview URL
    init() {
        this.fetchCategories();
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
    previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            this.imagePreview = URL.createObjectURL(file); // Generate a preview URL
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
        formData.append('ruta', fileInput.files[0]); // Append the image file
        formData.append('titulo', titleInput.value); // Append the title
        formData.append('categoria_id', categorySelect.value); // Append the category ID
        formData.append('user_id', 1); // Replace with the actual user ID

        fetch('http://localhost:8000/api/imagenes', {
            method: 'POST',
            body: formData, // Send the form data
        })
        .then(response => response.json())
        .then(data => {
            console.log('Imagen subida:', data);
            alert('Imagen subida exitosamente.');
            this.imagePreview = null; // Clear the preview
            fileInput.value = ''; // Reset the file input
            titleInput.value = ''; // Reset the title input
            categorySelect.value = ''; // Reset the category select
        })
        .catch(error => console.error('Error al subir la imagen:', error));
    },
}));
Alpine.start();
