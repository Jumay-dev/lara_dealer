let mix = require('laravel-mix');
const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin')

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

mix
.options({
    extractVueStyles: true,
  })
//   .webpackConfig({
//     plugins: [new VuetifyLoaderPlugin()]
//   })

    .js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');
