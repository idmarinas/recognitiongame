<div class="row bgcolor6 justify-content-between no-gutters">
    <div class="row no-gutters">
        <div class="d-none d-md-flex">
            <img src="img/logo/sitelogo.png" class="img_logo">
        </div>
        <div class="col my-auto">
            <div class="div_maintitle"> {{RecognitionGame\Models\Webpagetext::where('id',2)->pluck('name_'.session('rg_lang'))->first()}}</div>
            <div class="div_submaintitle"> {{RecognitionGame\Models\Webpagetext::where('id',3)->pluck('name_'.session('rg_lang'))->first()}} &bull; {{RecognitionGame\Models\Webpagetext::where('id',4)->pluck('name_'.session('rg_lang'))->first()}} &bull; {{RecognitionGame\Models\Webpagetext::where('id',5)->pluck('name_'.session('rg_lang'))->first()}}</div>
        </div>
    </div>
    <div class="col my-auto">
        <a href="{{route('changelang',['route'=>url()->current(),'lang'=>session('rg_lang')=='hu'?'en':'hu'])}}">
            <img class="img_flag float-right img-responsive" src="img/lang/flag_{{session('rg_lang')=='hu'?'en':'hu'}}.png" title="{{RecognitionGame\Models\Webpagetext::where('id',1)->pluck('name_'.(session('rg_lang')=='hu'?'en':'hu'))->first()}}">
        </a>
    </div>
</div>
<nav class="navbar navbar-expand-sm">
    <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-6" aria-controls="navbarSupportedContent-6" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars color4"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent-6">
        <ul class="navbar-nav mr-auto">
        <?php
            $menutexts = RecognitionGame\Models\Webpagetext::select('id', 'name_'.session('rg_lang'))->whereBetween('id',[1000,1003])->get();
            for($i=0;$i<count($menutexts);$i++){              
                print 
                    '<li class="nav-item">
                        <a class="nav-link" href="'.route(config('constants.routes')[$i]).'">' . $menutexts[$i]['name_'.session('rg_lang')].'</a>
                    </li>';
            }
        ?>
        </ul>
    </div>
</nav>
