<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CatsTags Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Cats
 * @property \Cake\ORM\Association\BelongsTo $Tags
 *
 * @method \App\Model\Entity\CatsTag get($primaryKey, $options = [])
 * @method \App\Model\Entity\CatsTag newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CatsTag[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CatsTag|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CatsTag patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CatsTag[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CatsTag findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CatsTagsTable extends Table
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

        $this->table('cats_tags');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Cats', [
            'foreignKey' => 'cats_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Tags', [
            'foreignKey' => 'tags_id',
            'joinType' => 'INNER'
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
            ->integer('id')
            ->allowEmpty('id', 'create');

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
        $rules->add($rules->existsIn(['cats_id'], 'Cats'));
        $rules->add($rules->existsIn(['tags_id'], 'Tags'));

        return $rules;
    }
}
