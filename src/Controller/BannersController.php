<?php
namespace BannersManager\Controller;

use BannersManager\Controller\AppController;
use Cake\Core\Configure;
use AppCore\Lib\ImageUploader;
use AppCore\Lib\ImageUploaderConfig;
use Cake\ORM\TableRegistry;
use AppCore\Lib\Utility\ArrayUtility;

/**
 * Banners Controller
 *
 * @property \BannersManager\Model\Table\BannersTable $Banners
 * @property \BannersManager\Model\Table\PositionsTable $Positions
 */
class BannersController extends AppController {

    public $helpers = ['AppCore.Form', 'DefaultAdminTheme.PanelMenu'];

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('BannersManager.Banners');
        $this->loadModel('BannersManager.Positions');
    }
	/**
	 * Index method
	 *
	 * @return void
	 */
	public function index() {
		$result = $this->Banners->getAllBanners();

		$inputsOptions = Configure::read('WebImobApp.Plugins.BannersManager.Settings.InputsOptions');

		$tableHeaders = [];
		$tableHeaders[] = 'Imagem';
		if($inputsOptions['use_name'])
			$tableHeaders[] = 'Nome';

		if($inputsOptions['use_link'])
			$tableHeaders[] = 'Link';

		$tableHeaders[] = 'Status';
		$tableHeaders[] = 'Opções';

		$this->set('tableHeaders', $tableHeaders);
		$this->set('options', $inputsOptions);
		$this->set('data', $result);
	}

	public function add() {
		if($this->request->is('post')){
			$data = $this->request->data;
			
			$position = $this->Positions->get($data['position_id']);

			if($position->type == 'image'){
				$image = $data['image'];
				$uploader = new ImageUploader();
                if($uploader->setData($image)) {
                    $uploader->setPath('banners/');
                    $uploader->setConfig(new ImageUploaderConfig($position->width, $position->height, $position->mode));
                    $uploadedData = $uploader->upload();
                    $data['image'] = $uploadedData;
                }
			}
			else {
				$data['image'] = '';
			}

			$banner = $this->Banners->newEntity($data);

			if($this->Banners->save($banner)){
				$this->Flash->set('Banner criado!', ['element' => 'alert_success']);
				unset($this->request->data['Banner']);
			}
			else{
				$this->Flash->set($banner->getErrorMessages(), ['element' => 'alert_danger']);
			}
		}
		
		$inputsOptions = Configure::read('WebImobApp.Plugins.BannersManager.Settings.InputsOptions');
        $positionsList = $this->Positions->getPositionsList();
		$this->set('options', $inputsOptions);
		$this->set('positionsList', $positionsList);
        $this->set('banner', $this->Banners->newEntity());
	}

	public function edit($id) {
		if($this->request->is('post')){
			$data = $this->request->data;
			
			$position = $this->Positions->get($data['position_id']);

			if($position->type == 'image'){
				$image = $data['image'];
				$data['image'] = '';
				$uploader = new ImageUploader();
				if($uploader->setData($image)) {
					$uploader->setPath('banners/');
                    $uploader->setConfig(new ImageUploaderConfig($position->width, $position->height, $position->mode));
					$uploadedData = $uploader->upload();
					$data['image'] = $uploadedData;
				}
			}
			else {
				$data['image'] = '';
			}

			if(empty($data['image']))
				unset($data['image']);

			$banner = $this->Banners->get($id);
			$banner = $this->Banners->patchEntity($banner, $data);
			if($this->Banners->save($banner)) {
				$this->Flash->set('Banner salvo!', ['element' => 'alert_success']);
			}
			else {
				$this->Flash->set($banner->getErrorMessages(), ['element' => 'alert_danger']);
			}
		}

		$banner = $this->Banners->get($id);
		$inputsOptions = Configure::read('WebImobApp.Plugins.BannersManager.Settings.InputsOptions');
        $positionsList = $this->Positions->getPositionsList();

		$this->set('options', $inputsOptions);
		$this->set('positionsList', ArrayUtility::markValue($positionsList, $banner->position_id, '(atual)'));
		$this->set('banner', $banner);
    }

	public function delete($id = null){
		$this->autoRender = false;

		$banner = $this->Banners->get($id);

		if($this->Banners->delete($banner)){
			$this->Flash->set('Banner deletado!', ['element' => 'alert_success']);
			unset($this->request->data);
		}
		else{
			$this->Flash->set('Não foi possível deletar o banner.', ['element' => 'alert_danger']);
		}
		return $this->redirect(['action' => 'index']);
	}
}
