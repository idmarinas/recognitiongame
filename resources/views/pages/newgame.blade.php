@extends(config('constants.masterpagePATH'))

@section('body')
    <newgame sessionData_Random="{{$share_sessionData_Random}}"></newgame>
@endsection