var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss');
});

elixir(function(mix) {
 /* mix.less('app.less', 'public/css', { paths: lessPaths })
  .scripts([
  'jquery/dist/jquery.min.js',
  'bootstrap/dist/js/bootstrap.min.js',
  'bootstrap-select/dist/js/bootstrap-select.min.js'
  ], 'public/js/vendor.js', bowerDir)*/
 //  .copy('resources/assets/js/app.js', 'public/js/app.js')
 //  .copy(bowerDir + 'font-awesome/fonts', 'public/fonts');

 mix.styles([
  "app.css",
  "custom.css"
 ]);
});
elixir(function(mix) {
 mix.version('css/all.css');

});