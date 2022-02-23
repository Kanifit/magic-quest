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
   .extract([
      'simplebar-vue',
      '@tweenjs/tween.js'
   ])
   .js('resources/js/reader.js', 'public/js')
    .js('resources/js/test.js', 'public/js')
    .js('resources/js/test-creator.js', 'public/js')
    .js('resources/js/step-creator.js', 'public/js')
   .js('resources/js/auth.js', 'public/js')
   .styles(['node_modules/simplebar/dist/simplebar.css'], 'public/css/plugins.css')
   .styles(['node_modules/v-markdown-editor/dist/v-markdown-editor.css'], 'public/css/editor.css')
   .sass('resources/sass/app.scss', 'public/css')
   .sass('resources/sass/book.sass', 'public/css')
   .sass('resources/sass/reader.sass', 'public/css')
   .sass('resources/sass/test.sass', 'public/css')
   .sass('resources/sass/test-creator.sass', 'public/css')
   .sass('resources/sass/step-creator.sass', 'public/css')
   .sass('resources/sass/preforms.sass', 'public/css')
   .sass('resources/sass/auth.sass', 'public/css')
   .sass('node_modules/slick-carousel/slick/slick.scss', 'public/css')
   .sass('node_modules/slick-carousel/slick/slick-theme.scss', 'public/css')
   .version();
