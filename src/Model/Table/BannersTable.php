<?php
namespace BannersManager\Model\Table;

use BannersManager\Model\Entity\Banner;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

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
            ->notEmpty('position_id')
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


    public function getAllActiveBanners() {
        return $this->find()
            ->contain(['Positions'])
            ->where(['Banners.active' => 1])
            ->matching('Positions', function ($q){ return $q->where(['Positions.active' => 1]); })
            ->all();
    }
}
