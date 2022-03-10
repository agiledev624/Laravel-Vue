let mix = require('laravel-mix')

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
mix.options({
  autoprefixer: { remove: false },
  // hmrOptions: {
  //   host: 'localhost', // mysite.test is my local domain used for testing
  //   port: 8080,
  // },
})

mix
  .js('resources/assets/js/app.js', 'public/js')
  .js('resources/assets/js/admin.js', 'public/js')
  .vue({ extractStyles: true, globalStyles: false })
  .sass('resources/assets/sass/app.scss', 'public/css')
