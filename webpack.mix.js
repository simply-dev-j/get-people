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

mix.js('resources/js/app.js', 'public/js')
    .scripts([
        'resources/js/vendor/jquery-3.5.1.min.js',
        'resources/js/vendor/jquery-ui.min.1.12.1.js',
        'resources/js/vendor/bootstrap.min.js'
    ], 'public/js/vendor.js')
    .sass('resources/css/app.scss', 'public/css', [
        //
    ]);
