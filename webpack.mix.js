const mix = require('laravel-mix');

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


 //mix.sass('resources/sass/app.scss', 'public/css');

   mix.styles([
      'resources/assets/css/font-awesome.min.css',
      'resources/assets/css/simple-line-icons.min.css',
      'resources/assets/css/style.css'
  ], 'public/css/plantilla.css')
  .sass('resources/sass/app.scss', 'public/css')
  .scripts([
      //'resources/assets/js/jquery.min.js',
      'resources/assets/js/popper.min.js',
      'resources/assets/js/bootstrap.min.js',
      'resources/assets/js/Chart.min.js',
      'resources/assets/js/pace.min.js',
      'resources/assets/js/template.js',
      'resources/assets/js/sweetalert2.all.js'
  ], 'public/js/plantilla.js')
  .js('resources/js/app.js', 'public/js');
