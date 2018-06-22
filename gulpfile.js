var elixir = require('laravel-elixir');
 
elixir(function(mix) {
    mix.scripts(['master.js'],'public/js/master.min.js');
    mix.sass('answer_button.scss','public/css/answer_button.min.css');
    mix.sass('master.scss','public/css/master.min.css');
});