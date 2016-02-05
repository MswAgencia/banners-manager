<?php
namespace BannersManager\Model\Table;

use BannersManager\Model\Entity\Banner;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Cache\Cache;
use Cake\Filesystem\File;
use Cake\Event\Event;


/**
 * Banners Model
 */
class BannersTable extends Table
{

  /**
   * Initialize method
   *
   * @param array $config The configuration for the Table.
   * @return void
   */
  public function initialize(array $config)
  {
    $this->table('banners');
    $this->displayField('name');
    $this->primaryKey('id');
    $this->belongsTo('Positions', [
      'foreignKey' => 'position_id',
      'className' => 'BannersManager.Positions'
    ]);
  }

  /**
   * Default validation rules.
   *
   * @param \Cake\Validation\Validator $validator Validator instance.
   * @return \Cake\Validation\Validator
   */
  public function validationDefault(Validator $validator)
  {
    $validator
      ->add('id', 'valid', ['rule' => 'numeric'])
      ->allowEmpty('id', 'create')
      ->allowEmpty('name')
      ->allowEmpty('image')
      ->allowEmpty('description')
      ->add('active', 'valid', ['rule' => 'numeric'])
      ->requirePresence('active', 'create')
      ->allowEmpty('active')
      ->add('position_id', 'valid', ['rule' => 'numeric'])
      ->requirePresence('position_id', 'create')
      ->notEmpty('position_id', 'Selecione uma posição de banner.')
      ->allowEmpty('text')
      ->allowEmpty('link');

    return $validator;
  }

  /**
   * Returns a rules checker object that will be used for validating
   * application integrity.
   *
   * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
   * @return \Cake\ORM\RulesChecker
   */
  public function buildRules(RulesChecker $rules)
  {
    $rules->add($rules->existsIn(['position_id'], 'Positions'));
    return $rules;
  }

  public function getAllBanners()
  {
    return $this->find()
      ->order(['Banners.sort_order' => 'ASC'])
      ->all();
  }

  public function getAllActiveBanners() {
    return $this->find()
      ->contain(['Positions'])
      ->where(['Banners.active' => 1])
      ->order(['Banners.sort_order' => 'ASC'])
      ->matching('Positions', function ($q){ return $q->where(['Positions.active' => 1]); })
      ->cache(function ($q){
          return 'bm_get_all_active_banners-' . md5(serialize($q->clause('where')));
      }, 'banners_manager_cache')
      ->all();
  }

  public function getAllActiveBannersFromPosition($positionId) {
    return $this->find()
      ->contain(['Positions'])
      ->where(['Banners.active' => 1])
      ->order(['Banners.sort_order' => 'ASC'])
      ->matching('Positions', function ($q) use ($positionId){ return $q->where(['Positions.active' => 1, 'Positions.id' => $positionId]); })
      ->cache(function ($q) use ($positionId){
          return 'bm_get_all_active_banners_from_pos-' . $positionId;
      }, 'banners_manager_cache')
      ->all();
  }


  public function afterDelete(Event $event, Banner $banner, \ArrayObject $options) {
    $bannerFile = new File(WWW_ROOT . 'img' . DS . $banner->image);
    $bannerFile->delete();
    $bannerFile->close();

    Cache::clear(false, 'banners_manager_cache');
  }

  public function beforeSave(Event $event, Banner $banner, \ArrayObject $options)
  {
    Cache::clear(false, 'banners_manager_cache');
  }
}
