<?php

use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Cache\Cache;

$configDir = dirname(__FILE__) . DS;

try {
  if(file_exists(CONFIG . '/banners_manager.php')) {
    Configure::load('banners_manager', 'default', false);
  }
  else {
    Configure::config('banners_manager_config', new PhpConfig($configDir));
    Configure::load('default_settings', 'banners_manager_config', false);
    Configure::drop('banners_manager_config');
  }
}
catch(\Exception $e) {
  die($e->getMessage());
}

Cache::config('banners_manager_cache', [
  'className' => 'Cake\Cache\Engine\FileEngine',
  'duration' => '+1 week',
  'probability' => 100,
  'path' => CACHE . 'plugins' . DS . 'banners_manager' . DS
]);
