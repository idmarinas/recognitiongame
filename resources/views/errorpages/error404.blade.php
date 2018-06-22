@extends(config('constants.masterpagePATH'))

@section('body')
    <div class="container-fluid" style="height: 70vh !important;">
        <div class="row align-items-center color18 errormessage fontsize11 h-100 justify-content-center">            
            <div>{{RecognitionGame\Models\Webpagetext::find(21)->getAttribute('name_'.(session('rg_lang')))}}</div>
        </div>
    </div>
@endsection