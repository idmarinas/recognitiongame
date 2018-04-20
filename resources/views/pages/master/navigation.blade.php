<div class="row justify-content-between bgcolor8">
    <div class="col">
        <div class="row">
            <div class="table_vertalign_table">
                <div class="table_vertalign_firstcell d-none d-sm-block">
                    <img src="img/logo/sitelogo.png" class="img_logo">
                </div>
                <div class="table_vertalign_midcell">
                    <span class="span_maintitle"> {{RecognitionGame\Models\Webpagetext::where('id',2)->pluck('text_'.session('rg_lang'))->first()}}</span><br>
                    <span class="span_submaintitle"> {{RecognitionGame\Models\Webpagetext::where('id',3)->pluck('text_'.session('rg_lang'))->first()}} &bull; {{RecognitionGame\Models\Webpagetext::where('id',4)->pluck('text_'.session('rg_lang'))->first()}} &bull; {{RecognitionGame\Models\Webpagetext::where('id',5)->pluck('text_'.session('rg_lang'))->first()}}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column justify-content-around">
        <a href="{{route('changelang',['route'=>Route::currentRouteName(),'lang'=>session('rg_lang')=='hu'?'en':'hu'])}}">
            <img src="img/lang/flag_{{session('rg_lang')=='hu'?'en':'hu'}}.png" class="img_flag" title="{{RecognitionGame\Models\Webpagetext::where('id',1)->pluck('text_'.(session('rg_lang')=='hu'?'en':'hu'))->first()}}">
        </a>
    </div>
</div>
</div>
<nav class="navbar navbar-expand-sm">
    <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-6" aria-controls="navbarSupportedContent-6" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars color2"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent-6">
        <ul class="navbar-nav mr-auto">
        <?
            $menutexts = RecognitionGame\Models\Webpagetext::select('id', 'text_'.session('rg_lang'))->whereBetween('id',[1000,1003])->get();
            for($i=0;$i<count($menutexts);$i++){              
                print 
                    '<li class="nav-item">
                        <a class="nav-link" href="'.route(config('constants.routes')[$i]).'">' . $menutexts[$i]['text_'.session('rg_lang')].'</a>
                    </li>';
            }
        ?>
        </ul>
    </div>
</nav>
