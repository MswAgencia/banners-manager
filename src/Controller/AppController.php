<?php

namespace BannersManager\Controller;

use ControlPanel\Controller\AppController as BaseController;
use Cake\Core\Configure;

class AppController extends BaseController {

  public function initialize()
  {
    parent::initialize();
    $this->loadHelper('Form', ['className' => 'MswAgencia.Form']);
  }
}
