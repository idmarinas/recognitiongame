<?php

namespace RecognitionGame\Providers;
use Illuminate\Support\ServiceProvider; 

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){
        $rg_lang=session('rg_lang');
        if (session('rg_lang')===null){
            switch (parse_url(url()->full())['host']) {
                case 'recognitiongame.com':
                    $rg_lang = 'en';
                    break;
                default:
                    $rg_lang = 'hu';
                    break;
            }
            $rg_lang = 'en';
            session(['rg_lang'=>$rg_lang]);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
