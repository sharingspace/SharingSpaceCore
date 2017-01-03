var elixir = require('laravel-elixir');
require('laravel-elixir-codeception');
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
    mix.sass(['app.scss', 'essentials.scss'],'public/assets/css/compiled');

    mix.codeception();
});

elixir(function(mix) {
    mix.sass('color_scheme/spring.scss','public/assets/css/color_scheme');
    mix.sass('color_scheme/organic.scss','public/assets/css/color_scheme');
    mix.sass('color_scheme/future.scss','public/assets/css/color_scheme');
    mix.sass('color_scheme/muted.scss','public/assets/css/color_scheme');
    mix.sass('color_scheme/starryNight.scss','public/assets/css/color_scheme');
    mix.sass('color_scheme/fresh.scss','public/assets/css/color_scheme');
    mix.sass('color_scheme/blue.scss','public/assets/css/color_scheme');
    mix.sass('color_scheme/brown.scss','public/assets/css/color_scheme');
    mix.sass('color_scheme/darkblue.scss','public/assets/css/color_scheme');
    mix.sass('color_scheme/darkgreen.scss','public/assets/css/color_scheme');
    mix.sass('color_scheme/darkorange.scss','public/assets/css/color_scheme');
    mix.sass('color_scheme/green.scss','public/assets/css/color_scheme');
    mix.sass('color_scheme/lightgrey.scss','public/assets/css/color_scheme');
    mix.sass('color_scheme/orange.scss','public/assets/css/color_scheme');
    mix.sass('color_scheme/pink.scss','public/assets/css/color_scheme');
    mix.sass('color_scheme/red.scss','public/assets/css/color_scheme');
    mix.sass('color_scheme/gold.scss','public/assets/css/color_scheme');

    mix.codeception();
});
