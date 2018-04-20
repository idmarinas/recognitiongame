@extends(config('constants.masterpagePATH'))

@section('body')
<div class="card">
    <div class="card-title_type1">
        {{RecognitionGame\Models\Webpagetext::where('id',1001)->pluck('text_'.session('rg_lang'))->first()}}
    </div>
    <div class="card-body_type1">
        <contact_ang2form_contact><div class="angular_loading"></div></contact_ang2form_contact>
    </div>
</div>
@endsection