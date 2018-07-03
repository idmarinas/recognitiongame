<div class="row no-gutters bgcolor6 justify-content-between">
    <div class="d-flex flex-row p-1">
        <div class="d-none d-md-flex">
            <img src="img/logo/sitelogo.png" class="img_logo">
        </div>
        <div class="my-auto">
            <div class="color5 fontsize8 fontweight2"> {{RecognitionGame\Models\Webpagetext::find(2)->getAttribute('name_'.session('rg_lang'))}}</div>
            <div class="color5 fontsize5"> {{RecognitionGame\Models\Webpagetext::find(3)->getAttribute('name_'.session('rg_lang'))}} &bull; {{RecognitionGame\Models\Webpagetext::find(4)->getAttribute('name_'.session('rg_lang'))}} &bull; {{RecognitionGame\Models\Webpagetext::find(5)->getAttribute('name_'.session('rg_lang'))}}</div>
        </div>
    </div>
    <div class="my-auto pr-1">
        @if ($share_pageID!=5)
            <a href="{{route('changelang',['route'=>url()->current(),'lang'=>session('rg_lang')=='hu'?'en':'hu'])}}">
                <img class="img_flag" src="img/lang/flag_{{session('rg_lang')=='hu'?'en':'hu'}}.png" title="{{RecognitionGame\Models\Webpagetext::find(1)->getAttribute('name_'.(session('rg_lang')=='hu'?'en':'hu'))}}">
            </a>
        @endif
    </div>
</div>
<nav class="navbar navbar-expand-sm">
    <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarContent">
        <i class="fas fa-bars link2"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav">
        <?php
            $menutexts = RecognitionGame\Models\Webpagetext::select('id', 'name_'.session('rg_lang'))->whereBetween('id',[1000,1003])->get();
            for($i=0;$i<count($menutexts);$i++)          
                print 
                    '<li class="nav-item">
                        <a class="nav-link link2 fontweight2" href="'.route(config('constants.routes')[$i]).'">' . $menutexts[$i]['name_'.session('rg_lang')].'</a>
                    </li>';
        ?>
        </ul>
    </div>
</nav>
