const mix = require('laravel-mix');
const path = require('path');
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
mix.copyDirectory('resources/images', 'public/images');
mix.js('resources/js/app.js', 'public/js')
    .vue({
        extractStyles: true,
        version: 2
    })
    .sass('resources/sass/app.scss', 'public/css')
    .options({
        postCss: [
            require('postcss-import')
        ]
    })
    .webpackConfig(require('./webpack.config.js'))
    .version();
