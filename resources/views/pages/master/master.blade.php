<!doctype html>
<html lang="{{ session('rg_lang') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="./img/logo/favicon.ico" rel="icon" type="image/x-icon"/>
        <title>{{RecognitionGame\Models\Webpagetext::where('id',2)->pluck('text_'.(session('rg_lang')))->first()}}</title>
        <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/toastr.min.js"></script>
        <script type="text/javascript" src="js/master.min.js"></script>
        @if ($share_pageID==1000)
            <link rel="stylesheet" href="css/error.css">
        @endif
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="js/angular/styles.bundle.css">
        <link rel="stylesheet" href="css/toastr.min.css">
        <link rel="stylesheet" href="css/master.min.css">
        <script defer src="/img/fontawesome/svg-with-js/js/fontawesome-all.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            @include('pages/master/navigation')
            @if ($share_pageID==1000)
                @yield('body')
            @else
                    <div class="row no-gutters">
                        <div class="col-md-2 d-none d-md-block">
                            One of three columnsgh  dgh df h dfgh dOne of three columnsgh  dgh df h dfgh dOne of three columnsgh  dgh df h dfgh dOne of three columnsgh  dgh df h dfgh dOne of three columnsgh  dgh df h dfgh dOne of three columnsgh  dgh df h dfgh d
                            One of three columnsgh  dgh df h dfgh dOne of three columnsgh  dgh df h dfgh dOne of three columnsgh  dgh df h dfgh dOne of three columnsgh  dgh df h dfgh d
                        </div>
                        <div class="col-md-8">
                            @yield('body')
                        </div>
                        <div class="col-md-2 d-none d-md-block">
                            @if (($share_pageID==2)||($share_pageID==3))
                                <div class="card">
                                    <div class="card-title_type2">
                                        {{RecognitionGame\Models\Webpagetext::where('id',12)->pluck('text_'.(session('rg_lang')))->first()}}                
                                    </div>
                                    <div class="card-body_type2">
                                        <div class="text-justify">
                                            {{RecognitionGame\Models\Webpagetext::where('id',13)->pluck('text_'.session('rg_lang'))->first()}}                                            
                                        </div>    
                                        <div class="text-justify">
                                            {{RecognitionGame\Models\Webpagetext::where('id',14)->pluck('text_'.session('rg_lang'))->first()}}                                            
                                        </div>   
                                        <div class="text-center"><strong>
                                            {{RecognitionGame\Models\Webpagetext::where('id',15)->pluck('text_'.session('rg_lang'))->first()}}                                            
                                        </strong></div>    
                                     </div>
                                </div>
                            @endif
                        </div>
                    </div>
            @endif
        </div>
        <script type="text/javascript" src="js/angular/inline.bundle.js"></script>
        <script type="text/javascript" src="js/angular/polyfills.bundle.js"></script>
        <script type="text/javascript" src="js/angular/main.bundle.js"></script>
    </body>
</html>
