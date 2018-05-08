<?php

namespace RecognitionGame\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
class LaravelLoggerProxy {
    public function log( $msg ) {
        Log::info($msg);
    }
}

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $rg_lang=session('rg_lang');
        if (session('rg_lang')===null){
            switch (parse_url(url()->full())['host']) {
                case 'felismero':
                    $rg_lang = 'hu';
                    break;
                default:
                    $rg_lang = 'en';
                    break;
            }
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
