<?php
namespace BannersManager\Controller;

use BannersManager\Controller\AppController;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\File;
use MswAgencia\Image\Image;
use SimpleFileUploader\FileUploader;

class BannersController extends AppController {

  public function initialize()
  {
    parent::initialize();
    $this->loadModel('BannersManager.Banners');
    $this->loadModel('BannersManager.Positions');
  }

	public function index() {
		$result = $this->Banners->getAllBanners();

		$options = Configure::read('MswAgencia.Plugins.BannersManager.Settings.Options');

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

        if($uploadedImage) {
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
			}
			else {
				$data['image'] = '';
			}

			$banner = $this->Banners->newEntity($data);

			if($this->Banners->save($banner)){
				$this->Flash->set('Banner criado!', ['element' => 'ControlPanel.alert_success']);
        $this->request->data = [];
			}
			else{
				$this->Flash->set($banner->getErrorMessages(), ['element' => 'ControlPanel.alert_danger']);
			}
		}

		$options = Configure::read('MswAgencia.Plugins.BannersManager.Settings.Options');
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

        if($uploadedImage) {
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
    	}
			else {
				$data['image'] = '';
			}

			if(empty($data['image']))
				unset($data['image']);

			$banner = $this->Banners->get($id);
			$banner = $this->Banners->patchEntity($banner, $data);
			if($this->Banners->save($banner)) {
				$this->Flash->set('Banner salvo!', ['element' => 'ControlPanel.alert_success']);
			}
			else {
				$this->Flash->set($banner->getErrorMessages(), ['element' => 'ControlPanel.alert_danger']);
			}
		}

		$banner = $this->Banners->get($id);
		$options = Configure::read('MswAgencia.Plugins.BannersManager.Settings.Options');
    $positionsList = $this->Positions->getPositionsAvailableList();

		$this->set('options', $options);
		$this->set('positionsList', $positionsList, $banner->position_id);
		$this->set('banner', $banner);
  }

	public function delete($id = null){
		$this->autoRender = false;

		$banner = $this->Banners->get($id);

		if($this->Banners->delete($banner)){
			$this->Flash->set('Banner deletado!', ['element' => 'ControlPanel.alert_success']);
  		$this->request->data = [];
		}
		else{
			$this->Flash->set('Não foi possível deletar o banner.', ['element' => 'ControlPanel.alert_danger']);
		}
		return $this->redirect(['action' => 'index']);
	}
}
