@extends(config('constants.masterpagePATH'))
@section('head_script')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
@stop
@section('body')
    <newgame sessionData_Random="{{$share_sessionData_Random}}"></newgame>
@endsection