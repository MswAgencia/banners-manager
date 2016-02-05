<?php
namespace BannersManager\Controller;

use BannersManager\Controller\AppController;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\File;
use AppCore\Lib\Utility\ArrayUtility;
use AppCore\Lib\Image\Image;
use SimpleFileUploader\FileUploader;

class BannersController extends AppController {

  public $helpers = ['AppCore.Form', 'DefaultAdminTheme.PanelMenu'];

  public function initialize()
  {
    parent::initialize();
    $this->loadModel('BannersManager.Banners');
    $this->loadModel('BannersManager.Positions');
  }

	public function index() {
		$result = $this->Banners->getAllBanners();

		$options = Configure::read('WebImobApp.Plugins.BannersManager.Settings.Options');

		$tableHeaders = [];
		$tableHeaders[] = 'Imagem';

		if($options['use_name'])
			$tableHeaders[] = 'Nome';

		if($options['use_link'])
			$tableHeaders[] = 'Link';

		$tableHeaders[] = 'Status';
		$tableHeaders[] = 'Opções';

		$this->set('tableHeaders', $tableHeaders);
		$this->set('options', $options);
		$this->set('data', $result);
	}

	public function add() {
		if($this->request->is('post')){
			$data = $this->request->data;

			$position = $this->Positions->get($data['position_id']);

			if($position->type == 'image'){
        $uploader = new FileUploader();
        $uploader->allowTypes('image/jpg', 'image/jpeg', 'image/png', 'image/gif')
          ->setDestination(TMP . 'uploads');

        $uploadedImage = $uploader->upload($data['image']);
        $image = new Image($uploadedImage);
        $image->resizeTo($position->width, $position->height, $position->mode);

        $banner = $image->save(WWW_ROOT . 'img/banners/');
        if($banner) {
          $data['image'] = 'banners/' . $banner->getFilename();
        }
        else {
          $data['image'] = '';
        }
        $file = new File($uploadedImage);
        $file->delete();
        $image->close();
			}
			else {
				$data['image'] = '';
			}

			$banner = $this->Banners->newEntity($data);

			if($this->Banners->save($banner)){
				$this->Flash->set('Banner criado!', ['element' => 'alert_success']);
        $this->request->data = [];
			}
			else{
				$this->Flash->set($banner->getErrorMessages(), ['element' => 'alert_danger']);
			}
		}

		$options = Configure::read('WebImobApp.Plugins.BannersManager.Settings.Options');
    $positionsList = $this->Positions->getPositionsAvailableList();
		$this->set('options', $options);
		$this->set('positionsList', $positionsList);
    $this->set('banner', $this->Banners->newEntity());
	}

	public function edit($id) {
		if($this->request->is('post')){
			$data = $this->request->data;

			$position = $this->Positions->get($data['position_id']);

			if($position->type == 'image'){
        $uploader = new FileUploader();
        $uploader->allowTypes('image/jpg', 'image/jpeg', 'image/png', 'image/gif')
          ->setDestination(TMP . 'uploads');

        $uploadedImage = $uploader->upload($data['image']);
        $image = new Image($uploadedImage);
        $image->resizeTo($position->width, $position->height, $position->mode);

        $banner = $image->save(WWW_ROOT . 'img/banners/');
        if($banner) {
          $data['image'] = 'banners/' . $banner->getFilename();
        }
        else {
          $data['image'] = '';
        }
        $file = new File($uploadedImage);
        $file->delete();
        $image->close();
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
		$options = Configure::read('WebImobApp.Plugins.BannersManager.Settings.Options');
    $positionsList = $this->Positions->getPositionsAvailableList();

		$this->set('options', $options);
		$this->set('positionsList', ArrayUtility::markValue($positionsList, $banner->position_id, '(atual)'));
		$this->set('banner', $banner);
  }

	public function delete($id = null){
		$this->autoRender = false;

		$banner = $this->Banners->get($id);

		if($this->Banners->delete($banner)){
			$this->Flash->set('Banner deletado!', ['element' => 'alert_success']);
  		$this->request->data = [];
		}
		else{
			$this->Flash->set('Não foi possível deletar o banner.', ['element' => 'alert_danger']);
		}
		return $this->redirect(['action' => 'index']);
	}
}
