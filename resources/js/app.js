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


// Variables para el Slider de la página de inicio
document.addEventListener('DOMContentLoaded', () => {
    const slider = document.querySelector('[data-slider]');
    const slides = slider.children;
    const prevButton = document.querySelector('[data-prev]');
    const nextButton = document.querySelector('[data-next]');
    let currentIndex = 0;

    // Define el tiempo entre cada slide (5 segundos)
    const intervalTime = 5000;
    let autoSlide;

    const updateSlider = () => {
        const totalSlides = slides.length;
        const offset = -(currentIndex * 100); // Desplaza el slider al slide actual
        slider.style.transform = `translateX(${offset}%)`;
    };

    const nextSlide = () => {
        currentIndex = (currentIndex + 1) % slides.length; // Incrementa el índice cíclicamente
        updateSlider();
    };

    const startAutoSlide = () => {
        autoSlide = setInterval(nextSlide, intervalTime); // Usa `nextSlide` para avanzar automáticamente
    };

    const stopAutoSlide = () => {
        clearInterval(autoSlide);
    };

    // Botón "Anterior"
    prevButton.addEventListener('click', () => {
        stopAutoSlide();
        currentIndex = (currentIndex === 0) ? slides.length - 1 : currentIndex - 1;
        updateSlider();
        startAutoSlide();
    });

    // Botón "Siguiente"
    nextButton.addEventListener('click', () => {
        stopAutoSlide();
        nextSlide();
        startAutoSlide();
    });

    // Inicia el slider automático
    startAutoSlide();
});
