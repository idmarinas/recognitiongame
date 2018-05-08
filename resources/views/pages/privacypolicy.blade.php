@extends(config('constants.masterpagePATH'))

@section('body')
<div class="card">
    <div class="card-header card-header_type1">
        {{RecognitionGame\Models\Webpagetext::find(1004)->getAttribute('name_'.session('rg_lang'))}}
    </div>
    <div class="card-body_type1">
        <p class="text-justify">
            <?php
                print RecognitionGame\Models\Webpagetext::where('id',125)->pluck('name_'.session('rg_lang'))->first();
            ?>
        </p>
    </div>
</div>
@endsection