@extends(config('constants.masterpagePATH'))

@section('body') 
    <div class="card">
        <div class="card-header card-header_type1">
            {{RecognitionGame\Models\Webpagetext::find(11)->getAttribute('name_'.session('rg_lang'))}}
        </div>
        <div class="card-body card-body_type1">
            <index_ang2index><div class="angular_loading"></div></index_ang2index>
        </div>
    </div>
@endsection
<!-- <script src="https://js.pusher.com/4.1/pusher.min.js"></script>

<script type="text/javascript">
      // Enable pusher logging - don't include this in production
     
      Pusher.logToConsole = true;


      var pusher = new Pusher('7ba1dc73a0277f6cc393', {
        cluster: 'mt1',
        encrypted: false
      });

      
      // Subscribe to the channel we specified in our Laravel Event
      var channel = pusher.subscribe('my-channel');
      Pusher.log = function(msg) {
  console.log(msg);
};

      // Bind a function to a Event (the full Laravel class)
          
channel.bind('my-event', function(data) {
      alert(data);
    });

//       channel.bind('pusher:subscription_succeeded', function(members) {
//         alert('successfully subscribed1!');
// });

    </script> -->