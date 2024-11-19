import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.js",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                title: ['"Zilla Slab"', ...defaultTheme.fontFamily.serif], // Fuente personalizada para títulos
                body: ['"Open Sans"', "sans-serif"], // Fuente para el resto del texto
            },
            screens: {
                "3xl": "1920px",
            },
        },
    },

    plugins: [forms, require("@tailwindcss/typography")],
};
