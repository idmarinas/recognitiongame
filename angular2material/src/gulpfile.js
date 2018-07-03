var elixir = require('laravel-elixir');
elixir.config.production = true;
 
elixir(function(mix) {
    // Minimized result:
    //mix.sass('master.scss','public/css/master.min.css',null,{outputStyle:'compressed'});
    mix.sass('master.scss');
});

elixir(function(mix) {
    mix.sass('error.scss');
});