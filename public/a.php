<?php
  require __DIR__ . '\..\vendor/autoload.php';

  $options = array(
    'host' => 'api.pusherapp.com',
    'encrypted' => true
  );
  $pusher = new Pusher(
    '17a39fa97f26300c9a36',
    '50b4488ceccc08ea48e0',
    '519532',
    $options
  );

  $data['message'] = 'hello world';
  $pusher->trigger('my-channel', 'my-event', $data);
?>