@extends(config('constants.masterpagePATH'))

@section('body')
<div class="card">
    <div class="card-header card-header_type1">
        {{RecognitionGame\Models\Webpagetext::find(1003)->getAttribute('name_'.session('rg_lang'))}}
    </div>
    <div class="card-body_type1">
        <themestopics_ang2form_themestopics><div class="angular_loading"></div></themestopics_ang2form_themestopics>
    </div>
</div>
@endsection