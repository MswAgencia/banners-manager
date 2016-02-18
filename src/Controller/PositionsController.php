<?php
namespace BannersManager\Controller;

use BannersManager\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class PositionsController extends AppController {
	public function initialize()
	{
		parent::initialize();
		$this->loadModel('BannersManager.Positions');
	}

	public function index() {
		$result = $this->Positions->find()->all();

		$this->set('data', $result);
		$this->set('tableHeaders', ['Nome', 'Tipo', 'Status', 'Opções']);
	}

	public function add() {
		if($this->request->is('post')){
			$data = $this->request->data;

			$position = $this->Positions->newEntity($data);

			if($this->Positions->save($position)){
				$this->Flash->set('Posição cadastrada.', ['element' => 'ControlPanel.alert_success']);
				$this->request->data = [];
			}
			else{
				$this->Flash->set($position->getErrorMessages(), ['element' => 'ControlPanel.alert_danger']);
			}
		}

    $this->set('position', $this->Positions->newEntity());
	}

	public function edit($id) {
		if($this->request->is('post')) {
			$data = $this->request->data;
			$position = $this->Positions->get($id);
			$position = $this->Positions->patchEntity($position, $data);

      if($this->Positions->save($position)) {
				$this->Flash->set('Posição editada!', ['element' => 'ControlPanel.alert_success']);
			}
			else {
				$this->Flash->set($position->getErrorMessages(), ['element' => 'ControlPanel.alert_danger']);
			}
		}

		$position = $this->Positions->get($id);
		$this->set('position', $position);
	}

	public function delete($id) {
		$this->autoRender = false;

		$position = $this->Positions->get($id);

		if($this->Positions->delete($position)){
			$this->Flash->set('Posição removida.', ['element' => 'ControlPanel.alert_success']);
		}
		else{
			$this->Flash->set('Não foi possível remover a posição.', ['element' => 'ControlPanel.alert_danger']);
		}

		return $this->redirect(['action' => 'index']);
	}
}
