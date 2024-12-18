const defaultTheme = require('tailwindcss/defaultTheme');
/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './app/**/*.php',
        './resources/**/*.html',
        './resources/**/*.js',
        './resources/**/*.jsx',
        './resources/**/*.ts',
        './resources/**/*.tsx',
        './resources/**/*.php',
        './resources/**/*.vue',
        './resources/**/*.twig',
    ],
    corePlugins: {
        preflight: false,
    },
    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                sans: ['Cosmic', 'sans-serif'],
            },
            backgroundImage: {
                'bg-offer': "url('/img/offer/bg-offer-light.png')",
                'bg-offer-dark': "url('/img/offer/bg-offer-dark.png')",
            }
        },
    },
    plugins: [],
}

