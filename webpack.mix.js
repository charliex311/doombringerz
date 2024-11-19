const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.js('resources/js/app.js', 'public/js')
//     .postCss('resources/css/app.css', 'public/css', [
//         //
//     ]);



mix.options({
    processCssUrls: false
})

mix.sass('resources/scss/cabinet/dashlite.scss', 'public/assets/css/cabinet.css')
mix.sass('resources/scss/excellent/main.scss', 'public/css/main.css')
mix.js('resources/js/cabinet/scripts.js', 'public/assets/js')
mix.js('resources/js/excellent/main.js', 'public/js')


mix.version()
