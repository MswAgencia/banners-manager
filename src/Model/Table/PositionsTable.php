<?php
namespace BannersManager\Model\Table;

use BannersManager\Model\Entity\Position;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Cache\Cache;

/**
 * Positions Model
 */
class PositionsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('positions');
        $this->displayField('name');
        $this->primaryKey('id');
        $this->hasMany('Banners', [
            'foreignKey' => 'position_id',
            'className' => 'BannersManager.Banners'
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
            ->requirePresence('name', 'create')
            ->notEmpty('name')
            ->add('active', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('active')
            ->requirePresence('type', 'create')
            ->notEmpty('type')
            ->add('width', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('width')
            ->add('height', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('height')
            ->allowEmpty('mode');

        return $validator;
    }

    public function afterDelete(Event $event, Position $position, \ArrayObject $options) {
        Cache::clear(false, 'banners_manager_cache');
    }

    public function beforeSave(Event $event, Position $position, \ArrayObject $options)
    {
        Cache::clear(false, 'banners_manager_cache');
    }
}
