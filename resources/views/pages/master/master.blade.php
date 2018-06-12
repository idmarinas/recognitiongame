<!doctype html>
<html lang="{{ session('rg_lang') }}">
    <head>
        <base href="{{URL::asset('/')}}" target="_top">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="./img/logo/favicon.ico" rel="icon" type="image/x-icon"/>
        <title>{{RecognitionGame\Models\Webpagetext::where('id',2)->pluck('name_'.(session('rg_lang')))->first()}}</title>
        <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/bootstrapmenu.min.js"></script>
        <script type="text/javascript" src="js/toastr.min.js"></script>
        <script type="text/javascript" src="js/master.min.js"></script>
        @if ($share_pageID==1000)
            <link rel="stylesheet" href="css/error.css">
        @endif
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="js/angular/styles.bundle.css">
        <link rel="stylesheet" href="css/answer_button.min.css">
        <link rel="stylesheet" href="css/toastr.min.css">
        <link rel="stylesheet" href="css/master.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
        <!-- Google Analytics -->
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
          ga('create', 'UA-91841956-1', 'auto');
          ga('send', 'pageview');
        </script>
        <!-- End of Google Analytics -->
    </head>
    <body>
        @include('pages/master/navigation')
        @if ($share_pageID==1000)
            @yield('body')
        @else
            <div class="row no-gutters">
                @if (($share_pageID!=5))
                    <div class="col-lg-2 d-none d-lg-block">
                        <master_proposal></master_proposal>
                        <master_quickgame></master_quickgame>
                        <master_databaseinfo></master_databaseinfo>
                   </div>
                @endif
                @if ($share_pageID!=5)
                    <div class="col-lg-8">
                @else
                    <div class="col-lg-9">
                @endif
                    @yield('body')
                </div>
                @if ($share_pageID==5)
                    <div class="col-lg-3">
                        <newgame_statistics></newgame_statistics>
                        <newgame_mistakequestion></newgame_mistakequestion>
                    </div>
                @else
                    <div class="col-lg-2 d-none d-lg-block">
                        <master_greeting></master_greeting>
                    </div>
                @endif
            </div>
        @endif
        <div class="footer">
            <?
                print   RecognitionGame\Models\Webpagetext::find(32)->getAttribute('name_'.session('rg_lang'))." <br /> "
                        .RecognitionGame\Models\Webpagetext::find(33)->getAttribute('name_'.session('rg_lang'))." <br /> ".
                        RecognitionGame\Models\Webpagetext::find(39)->getAttribute('name_'.session('rg_lang')).": ".
                        "<a class='link3' href='".route('contact')."'>".RecognitionGame\Models\Webpagetext::find(34)->getAttribute('name_'.session('rg_lang'))."</a>";
            ?>        
        </div>
        <script type="text/javascript" src="js/angular/inline.bundle.js"></script>
        <script type="text/javascript" src="js/angular/polyfills.bundle.js"></script>
        <script type="text/javascript" src="js/angular/main.bundle.js"></script>
    </body>
</html>
