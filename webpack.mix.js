const mix = require('laravel-mix');

mix.js('resources/js/products.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .version();
