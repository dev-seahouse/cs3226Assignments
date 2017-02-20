const { mix } = require('laravel-mix')
mix.browserSync('localhost:8000')
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
  .copy('node_modules/sweetalert2/dist/sweetalert2.css', 'resources/assets/vendor')
   .sass('resources/assets/sass/app.scss', 'public/css')
