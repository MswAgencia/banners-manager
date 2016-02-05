<?php

$starter = new \AppCore\Lib\PluginStarter();
$starter->load('BannersManager');

\Cake\Cache\Cache::config('banners_manager_cache', [
    'className' => 'Cake\Cache\Engine\FileEngine',
    'duration' => '+1 week',
    'probability' => 100,
    'path' => CACHE . 'plugins' . DS . 'banners_manager' . DS,
]);