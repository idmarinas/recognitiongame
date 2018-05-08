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
        <script defer src="/img/fontawesome/svg-with-js/js/fontawesome-all.js"></script>
    </head>
    <body>
        @include('pages/master/navigation')
        @if ($share_pageID==1000)
            @yield('body')
        @else
            <div class="row no-gutters flex-fill">
                @if (($share_pageID!=5))
                   <div class="col-lg-2 d-none d-lg-block">
                       <master_ang2div_proposal></master_ang2div_proposal>
                       <master_ang2div_quickgame></master_ang2div_quickgame></master_ang2div_quickgame>
                       <div class="card">
                           <div class="card-header_type2">
                               <div class="d-flex justify-content-between">
                                   <div>{{RecognitionGame\Models\Webpagetext::where('id',8)->pluck('name_'.session('rg_lang'))->first()}}</div>
                               </div>
                           </div>
                           <div class="card-body_type2">
                               <?
                                   $labels = RecognitionGame\Models\Webpagetext::whereIn('id', [1055, 1056, 1057, 9])->orderByRaw('FIELD (id, 50, 51, 52, 9)')->pluck('name_'.session('rg_lang'));
                                   $counts[0] = RecognitionGame\Models\Theme::where('parent',0)->count();
                                   $counts[1] = RecognitionGame\Models\Theme::where('parent', '<>', 0)->count();
                                   $counts[2] = RecognitionGame\Models\Topic::count();
                                   $counts[3] = RecognitionGame\Models\Image::count();
                                   foreach($labels as $i => $label){
                                       $pieceID = $counts[$i] >1 ? 17: 16;
                                       print "<div class=\"d-flex justify-content-between\">$label: <div><span class=\"color7\"><strong>$counts[$i]</strong></span> ".RecognitionGame\Models\Webpagetext::find($pieceID)->getAttribute('name_'.session('rg_lang'))."</div></div>";
                                   }
                               ?>
                           </div>
                       </div>
                   </div>
                @endif
                @if ($share_pageID!=5)
                    <div class="col-lg-8">
                @else
                    <div class="col-lg-9">
                @endif
                    @yield('body')
                </div>
                @if (($share_pageID!=5))
                <div class="col-lg-2 d-none d-lg-block">
                    <div class="card">
                        <div class="card-header_type2">
                            {{RecognitionGame\Models\Webpagetext::where('id',12)->pluck('name_'.(session('rg_lang')))->first()}}                
                        </div>
                        <div class="card-body_type2">
                            <div class="text-justify">
                                {{RecognitionGame\Models\Webpagetext::where('id',13)->pluck('name_'.session('rg_lang'))->first()}}                                            
                            </div>    
                            <div class="text-justify">
                                {{RecognitionGame\Models\Webpagetext::where('id',14)->pluck('name_'.session('rg_lang'))->first()}}                                            
                            </div>   
                            <div class="text-center"><strong>
                                {{RecognitionGame\Models\Webpagetext::where('id',15)->pluck('name_'.session('rg_lang'))->first()}}                                            
                            </strong></div>    
                         </div>
                    </div>
                </div>
                @endif
                @if ($share_pageID==5)
                    <div class="col-lg-3">
                        <newgame_ang2div_statistics></newgame_ang2div_statistics>
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
