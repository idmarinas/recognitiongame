@extends(config('constants.masterpagePATH'))

@section('body')
    <newgame_ang2newgame sessionData_Random="{{$share_sessionData_Random}}"></newgame_ang2newgame>
@endsection