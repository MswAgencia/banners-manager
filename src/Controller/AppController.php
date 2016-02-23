<?php

namespace BannersManager\Controller;

use ControlPanel\Controller\AppController as BaseController;
use Cake\Core\Configure;

class AppController extends BaseController {

  public function initialize()
  {
    parent::initialize();
    $this->helpers[] = ['Form' => ['className' => 'MswAgencia.Form']];
  }
}
