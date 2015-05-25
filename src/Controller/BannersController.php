<?php
namespace BannersManager\Controller;

use BannersManager\Controller\AppController;
use Cake\Core\Configure;
use AppCore\Lib\ImageUploader;
use Cake\ORM\TableRegistry;

/**
 * Banners Controller
 *
 * @property BannersManager\Model\Table\BannersTable $Banners
 */
class BannersController extends AppController {

	public $helpers = ['AppCore.Form', 'DefaultAdminTheme.PanelMenu'];
	/**
	 * Index method
	 *
	 * @return void
	 */
	public function index() {
		$realties = TableRegistry::get('BannersManager.Banners');
		$result = $realties->find()->order(['sort_order' => 'ASC'])->all();

		$inputsOptions = Configure::read('WebImobApp.Plugins.BannersManager.Settings.InputsOptions');

		$tableHeaders = [];
		$tableHeaders[] = 'Imagem';
		if($inputsOptions['use_name'])
			$tableHeaders[] = 'Nome';

		if($inputsOptions['use_link'])
			$tableHeaders[] = 'Link';

		$tableHeaders[] = 'Ativo';
		$tableHeaders[] = 'Opções';

		$this->set('tableHeaders', $tableHeaders);
		$this->set('options', $inputsOptions);
		$this->set('data', $result);
	}

	public function add() {
		// Registering tables
		$positionsTable = TableRegistry::get('BannersManager.Positions');
		$bannersTable = TableRegistry::get('BannersManager.Banners');

		if(isset($this->request->data['Banner'])){
			$data = $this->request->data['Banner'];
			
			$position = $positionsTable->get($data['position_id']);

			if($position->type == 'image'){
				$image = $data['image'];
				$uploader = new ImageUploader();
				$uploader->setData($image);
				$uploader->setPath('banners/');
				$uploader->width = $position->width;
				$uploader->height = $position->height;
				$uploader->mode = $position->mode;
				$uploadedData = $uploader->upload();
				$data['image'] = $uploadedData;
			}
			else {
				$data['image'] = '';
			}

			$banner = $bannersTable->newEntity($data);

			if($bannersTable->save($banner)){
				$this->Flash->set('Banner criado!', ['element' => 'alert_success']);
				unset($this->request->data['Banner']);
			}
			else{
				$this->Flash->set('Não foi possível criar o banner.', ['element' => 'alert_danger']);
			}
		}
		
		$inputsOptions = Configure::read('WebImobApp.Plugins.BannersManager.Settings.InputsOptions');
		$this->set('options', $inputsOptions);
		$positionsQuery = $positionsTable->find('list', ['keyField' => 'id', 'valueField' => 'name']);
		$this->set('positionsList', $positionsQuery->toArray());
	}

	public function edit($id) {
		// Registering tables
		$positionsTable = TableRegistry::get('BannersManager.Positions');
		$bannersTable = TableRegistry::get('BannersManager.Banners');

		if($this->request->is('post')){
			$data = $this->request->data;
			
			$position = $positionsTable->get($data['position_id']);

			if($position->type == 'image'){
				$image = $data['image'];
				$data['image'] = '';
				$uploader = new ImageUploader();
				if($uploader->setData($image)) {
					$uploader->setPath('banners/');
					$uploader->width = $position->width;
					$uploader->height = $position->height;
					$uploader->mode = $position->mode;
					$uploadedData = $uploader->upload();
					$data['image'] = $uploadedData;
				}
			}
			else {
				$data['image'] = '';
			}

			if(empty($data['image']))
				unset($data['image']);

			$banner = $bannersTable->get($id);
			$banner = $bannersTable->patchEntity($banner, $data);
			if($bannersTable->save($banner)) {
				$this->Flash->set('Banner salvo!', ['element' => 'alert_success']);
			}
			else {
				$this->Flash->set('Banner salvo!', ['element' => 'alert_danger']);
			}
		}

		$banner = $bannersTable->get($id);
		$inputsOptions = Configure::read('WebImobApp.Plugins.BannersManager.Settings.InputsOptions');
		$this->set('options', $inputsOptions);
		$positionsQuery = $positionsTable->find('list', ['keyField' => 'id', 'valueField' => 'name']);
		$this->set('positionsList', \AppCore\Lib\Utility\ArrayUtility::markValue($positionsQuery->toArray(), $banner->position_id, '(atual)'));
		$this->set('banner', $banner);
	}

	public function delete($id = null){
		$this->autoRender = false;

		$bannersTable = TableRegistry::get('BannersManagerApi.Banners');
		$banner = $bannersTable->get($id);

		if($bannersTable->delete($banner)){
			# preciso deletar o arquivo aqui. deve vir o caminho da imagem no response da api ou eu mesmo buscar antes de enviar o request.
			$this->Flash->set('Banner deletado!', ['element' => 'alert_success']);
			unset($this->request->data);
		}
		else{
			$this->Flash->set('Não foi possível deletar o banner.', ['element' => 'alert_danger']);
		}
		$this->redirect('/interno/banners');
	}
}
