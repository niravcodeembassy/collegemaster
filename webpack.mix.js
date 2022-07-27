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

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .copyDirectory('node_modules/admin-lte/plugins', 'public/js/plugins')
   .scripts([
      "public/js/plugins/datatables/jquery.dataTables.min.js",
      "public/js/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js",
      "public/js/plugins/datatables-responsive/js/dataTables.responsive.min.js",
   ],'public/js/datatables.js')
    .styles([
        "public/js/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css",
        "public/js/plugins/datatables-responsive/css/responsive.bootstrap4.css",
        'public/js/plugins/sweetalert2/sweetalert2.min.css',
        'public/js/plugins/select2/css/select2.min.css',
        'public/js/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css',
    ], 'public/css/backend-plugins.css')
    .scripts([
      "public/js/plugins/sweetalert2/sweetalert2.all.js",
      "public/js/plugins/jquery-validation/jquery.validate.min.js",
      "public/js/plugins/jquery-validation/additional-methods.js",
      "public/js/plugins/select2/js/select2.min.js",
   ], 'public/js/backend-plugins.js')

;
