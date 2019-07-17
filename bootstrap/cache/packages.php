<?php return array (
  'fideloper/proxy' => 
  array (
    'providers' => 
    array (
      0 => 'Fideloper\\Proxy\\TrustedProxyServiceProvider',
    ),
  ),
  'get-stream/stream-laravel' => 
  array (
    'providers' => 
    array (
      0 => 'GetStream\\StreamLaravel\\StreamLaravelServiceProvider',
    ),
    'aliases' => 
    array (
      'FeedManager' => 'GetStream\\StreamLaravel\\Facades\\FeedManager',
    ),
  ),
  'laravel/tinker' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
    ),
  ),
  'nesbot/carbon' => 
  array (
    'providers' => 
    array (
      0 => 'Carbon\\Laravel\\ServiceProvider',
    ),
  ),
  'overtrue/laravel-follow' => 
  array (
    'providers' => 
    array (
      0 => 'Overtrue\\LaravelFollow\\FollowServiceProvider',
    ),
  ),
);