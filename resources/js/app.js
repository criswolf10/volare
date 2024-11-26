import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();




// Variables para el menú
const menuToggle = document.getElementById("menu-toggle");
const sidebar = document.getElementById("sidebar");
const content = document.getElementById("content");

// Evento para mostrar u ocultar el sidebar
menuToggle.addEventListener("click", () => {
    // Mostrar u ocultar el sidebar
    sidebar.classList.toggle("hidden");

    // Detectar si estamos en tamaño `tl` o `xl`
    if (window.innerWidth <= '1279') {
        // Para mobile y tablet portrait, aplicar cambios verticales
        sidebar.classList.toggle("translate-y-full"); // Sidebar entra desde arriba
        content.classList.toggle("mt-16"); // Añade padding top para mobile
        content.classList.toggle("md:mt-20");
        content.classList.toggle("lg:mt-24");


    }
});






