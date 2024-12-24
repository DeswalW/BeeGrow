import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                ungu: '#624BD7',
                kuning: '#FFC603',
            },

            aspectRatio: {
                'w-16': 16,
                'h-9': 9,
            }
        },
    },

    plugins: [
        forms, require('flowbite/plugin'), require('@tailwindcss/aspect-ratio'), require('@tailwindcss/line-clamp'),
    ],
};
