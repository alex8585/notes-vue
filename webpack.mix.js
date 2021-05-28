const mix = require('laravel-mix')

//const path = require('path')

//const cssImport = require("postcss-import")
//const cssNesting = require("postcss-nesting")
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
  .ts('resources/js/app.ts', 'public/js')
  .vue()
  .postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    //cssImport(),
    //cssNesting(),
    require('tailwindcss'),
  ])
  .webpackConfig(require('./webpack.config.js'))

if (mix.inProduction()) {
  mix.version()
}

mix
  .version()
  .sourceMaps()
  .disableNotifications()
