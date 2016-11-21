<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CommentsTags Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Comments
 * @property \Cake\ORM\Association\BelongsTo $Tags
 *
 * @method \App\Model\Entity\CommentsTag get($primaryKey, $options = [])
 * @method \App\Model\Entity\CommentsTag newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CommentsTag[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CommentsTag|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CommentsTag patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CommentsTag[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CommentsTag findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CommentsTagsTable extends Table
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

        $this->table('comments_tags');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Comments', [
            'foreignKey' => 'comments_id',
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
        $rules->add($rules->existsIn(['comments_id'], 'Comments'));
        $rules->add($rules->existsIn(['tags_id'], 'Tags'));

        return $rules;
    }
}
