<?php
namespace BannersManager\Controller;

use BannersManager\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use BannersManager\Lib\Api\PositionsApiRequester as ApiRequester;


/**
 * Positions Controller
 *
 * @property BannersManager\Model\Table\PositionsTable $Positions
 */
class PositionsController extends AppController {
	public $helpers = ['AppCore.Form', 'DefaultAdminTheme.PanelMenu'];

	public function index() {
		$positions = TableRegistry::get('BannersManager.Positions');
		$result = $positions->find()->all();

		$this->set('data', $result);
		$this->set('tableHeaders', ['Nome', 'Tipo', 'Status', 'Opções']);
	}

	public function add() {
		if($this->request->is('post')){
			$data = $this->request->data;
					
			$positionsTable = TableRegistry::get('BannersManager.Positions');
			$position = $positionsTable->newEntity($data);
	        
			if($positionsTable->save($position)){
				$this->Flash->set('Posição cadastrada.', ['element' => 'alert_success']);
				unset($this->request->data['Position']);
			}
			else{
				$this->Flash->set('Não foi possível cadastrar nova posição.', ['element' => 'alert_danger']);
			}
		}
	}

	public function edit($id) {
		$positionsTable = TableRegistry::get('BannersManager.Positions');
		
		if($this->request->is('post')) {
			$data = $this->request->data;
			$position = $positionsTable->get($id);
			$position = $positionsTable->patchEntity($position, $data);
			if($positionsTable->save($position)) {
				$this->Flash->set('Posição editada!', ['element' => 'alert_success']);
			}
			else {
				$this->Flash->set('Não foi possível salvar a posição.', ['element' => 'alert_danger']);
			}
		}
		$position = $positionsTable->get($id);
		$this->set('position', $position);
	}

	public function delete($id = null) {
		$this->autoRender = false;
		$positionsTable = TableRegistry::get('BannersManager.Positions');
			
		$position = $positionsTable->get($id);

		if($positionsTable->delete($position)){
			$this->Flash->set('Posição removida.', ['element' => 'alert_success']);
		}
		else{
			$this->Flash->set('Não foi possível remover a posição.', ['element' => 'alert_danger']);
		}
		$this->redirect('/interno/banners/posicoes');
	}
}
