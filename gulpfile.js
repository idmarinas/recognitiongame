var elixir = require('laravel-elixir');
 
elixir(function(mix) {
    mix.scripts(['master.js'],'public/js/master.min.js');
    mix.sass('master.scss','public/css/master.min.css');
});

elixir(function(mix) {
    mix.sass('error.scss');
});