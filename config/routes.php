<?php
use Cake\Routing\Router;

Router::plugin('BannersManager', ['path' => '/interno/banners'], function($routes) {
	$routes->connect('/', ['controller' => 'Banners', 'action' => 'index']);
	$routes->connect('/novo', ['controller' => 'Banners', 'action' => 'add']);
	$routes->connect('/editar/:id', ['controller' => 'Banners', 'action' => 'edit'], ['id' => '\d+', 'pass' => ['id']]);
	$routes->connect('/remover/:id', ['controller' => 'Banners', 'action' => 'delete'], ['id' => '\d+', 'pass' => ['id']]);
	
	$routes->connect('/posicoes', ['controller' => 'Positions', 'action' => 'index']);
	$routes->connect('/posicoes/novo', ['controller' => 'Positions', 'action' => 'add']);
	$routes->connect('/posicoes/editar/:id', ['controller' => 'Positions', 'action' => 'edit'], ['id' => '\d+', 'pass' => ['id']]);
	$routes->connect('/posicoes/remover/:id', ['controller' => 'Positions', 'action' => 'delete'], ['id' => '\d+', 'pass' => ['id']]);
});
