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
    .js('resources/js/utility/SwalUtility.js', 'public/js/utility')
    .css('resources/css/styles.css', 'public/css')
    .css('resources/css/dataTable.css', 'public/css')
    .css('resources/css/laravel.css', 'public/css')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/customize.scss', 'public/css')
    .sass('resources/sass/table.scss', 'public/css')
    .sourceMaps();
