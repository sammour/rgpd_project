<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ConnectTypes Model
 *
 * @property \App\Model\Table\ConnectsTable|\Cake\ORM\Association\HasMany $Connects
 *
 * @method \App\Model\Entity\ConnectType get($primaryKey, $options = [])
 * @method \App\Model\Entity\ConnectType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ConnectType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ConnectType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ConnectType|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ConnectType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ConnectType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ConnectType findOrCreate($search, callable $callback = null, $options = [])
 */
class ConnectTypesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('connect_types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Connects', [
            'foreignKey' => 'connect_type_id'
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
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 25)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        return $validator;
    }
}
