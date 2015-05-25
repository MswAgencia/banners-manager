<?php
use Cake\Core\Configure;

return [
	'WebImobApp.Plugins.BannersManager.Settings' => [
		'General' => ['display_panel_menu' => true],
		'Template' => [
			'layout' => Configure::read('WebImobApp.Plugins.ControlPanel.Settings.Template.layout'), 
			'theme' => Configure::read('WebImobApp.Plugins.ControlPanel.Settings.Template.theme')
			],
		'InputsOptions' => [
			'use_name' => true,
			'use_link' => false,
			'use_description' => false,
			'use_order_field' => true
		]
	]
];
