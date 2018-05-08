@extends(config('constants.masterpagePATH'))

@section('body')
<div class="card">
    <div class="card-header card-header_type1">
        {{RecognitionGame\Models\Webpagetext::find(1001)->getAttribute('name_'.session('rg_lang'))}}
    </div>
    <div class="card-body card-body_type1">
        <contact_ang2form_contact></contact_ang2form_contact>
    </div>
    <div class="card-footer card-footer_type1">
        <div class="d-flex flex-start">
            <div class="pr-3"><strong>{{RecognitionGame\Models\Webpagetext::where('id',39)->pluck('name_'.session('rg_lang'))->first()}}:</strong></div>
            <div>recognitiongame@gmail.com</div>
        </div>
    </div>
</div>
@endsection