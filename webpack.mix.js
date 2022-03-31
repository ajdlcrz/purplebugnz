const { notify } = require('browser-sync');
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
    .js('resources/js/cms.js', 'public/js')
    .sass('resources/sass/cms.scss', 'public/css')
    .options({
        processCssUrls: false
    })
    .browserSync({
        proxy: process.env.APP_URL,
        files: [
            "./public/css/*.css",
            "./public/js/*.js",
            './resources/**/*.blade.php',
        ],
        notify: false
    })
    .disableNotifications();
    // .sourceMaps(); //use for local environment only
