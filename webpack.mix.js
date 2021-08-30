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
  .scripts('resources/assets/js', 'public/js/main.js')
  .styles('resources/assets/css', 'public/css/main.css')
  .combine([
    'resources/assets/plugins/**/*.css',
    'resources/assets/plugins/**/css/*.css',
    'resources/assets/plugins/**/dist/*.css',
  ], 'public/css/plugins.css')
  .combine([
    'resources/assets/plugins/**/*.js',
    'resources/assets/plugins/**/js/*.js',
    'resources/assets/plugins/**/dist/*.js',
  ], 'public/js/plugins.js')
  .sass('resources/scss/app.scss', 'public/css/custom.css')
  .postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
  ]);

if (mix.inProduction()) {
  mix.version();
}
