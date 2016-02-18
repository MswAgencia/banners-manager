<?php
use Cake\Core\Configure;

return [
	'MswAgencia.Plugins.BannersManager.Settings' => [
		'General' => ['display_panel_menu' => true],
		'Template' => [
			'layout' => Configure::read('MswAgencia.Plugins.ControlPanel.Settings.Template.layout'),
			'theme' => Configure::read('MswAgencia.Plugins.ControlPanel.Settings.Template.theme')
			],
		'Options' => [
			'use_name' => true,
			'use_link' => false,
			'use_description' => false,
			'use_order_field' => true
		]
	]
];
