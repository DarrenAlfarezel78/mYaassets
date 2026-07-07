import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Color palette elegan
                brand: {
                    red: '#EC2028',      // Merah khas
                    darkred: '#B8121B',  // Merah gelap untuk efek hover
                    dark: '#2A2A2A',     // Abu-abu sangat gelap (hampir hitam) untuk teks/header
                    light: '#F4F6F9',    // Background abu-abu sangat terang
                }
            }
        },
    },

    plugins: [forms],
};
