@extends(config('constants.masterpagePATH'))

@section('body')
<div class="card">
    <div class="card-title_type1">
        {{RecognitionGame\Models\Webpagetext::where('id',1003)->pluck('text_'.session('rg_lang'))->first()}}
    </div>
    <div class="card-body_type1">
        <p class="text-justify">
            <?
                print RecognitionGame\Models\Webpagetext::where('id',125)->pluck('text_'.session('rg_lang'))->first();
            ?>
        </p>
    </div>
</div>
@endsection