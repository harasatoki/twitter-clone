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
    .vue()
    .sass('resources/sass/app.scss', 'public/css')
    .js('resources/js/follow.js', 'public/js')
    .js('resources/js/favorite.js', 'public/js')
    .js('resources/js/popup.js', 'public/js')
    .js('resources/js/profile.js', 'public/js')
    .postCss('resources/css/popup.css', 'public/css')
    .postCss('resources/css/comment.css', 'public/css')
    ;
