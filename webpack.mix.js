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

mix
    .scripts([
        'resources/js/vendor/jquery-3.5.1.min.js',
        'resources/js/vendor/jquery-ui.min.1.12.1.js',
        'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
        'node_modules/@fortawesome/fontawesome-free/js/all.js'
    ], 'public/js/vendor.js')
    .scripts([
        'resources/js/app.js',
        'resources/js/scripts.js'
    ], 'public/js/app.js')

    .sass('resources/css/app.scss', 'public/css', [
        //
    ])
    .sass('resources/css/extension.scss', 'public/css', [
        //
    ])
    .version();
