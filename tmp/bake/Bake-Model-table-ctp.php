<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Utility\Inflector;
?>
<CakePHPBakeOpenTagphp
namespace <?= $namespace ?>\Model\Table;

<?php
$uses = [
    "use $namespace\\Model\\Entity\\$entity;",
    'use Cake\ORM\Query;',
    'use Cake\ORM\RulesChecker;',
    'use Cake\ORM\Table;',
    'use Cake\Validation\Validator;',
    'use Search\Manager;',
    'use Cake\Core\Configure;'
];
sort($uses);
echo implode("\n", $uses);
?>


/**
 * <?= $name ?> Model
<?php if ($associations): ?>
 *
<?php foreach ($associations as $type => $assocs): ?>
<?php foreach ($assocs as $assoc): ?>
 * @property \Cake\ORM\Association\<?= Inflector::camelize($type) ?> $<?= $assoc['alias'] ?>

<?php endforeach ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?= $name ?>Table extends Table
{

    public $filterTable = true;
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

<?php if (!empty($table)): ?>
        $this->table('<?= $table ?>');
<?php endif ?>
<?php if (!empty($displayField)): ?>
        $this->displayField('<?= $displayField ?>');
<?php endif ?>
<?php if (!empty($primaryKey)): ?>
<?php if (count($primaryKey) > 1): ?>
        $this->primaryKey([<?= $this->Bake->stringifyList((array)$primaryKey, ['indent' => false]) ?>]);
<?php else: ?>
        $this->primaryKey('<?= current((array)$primaryKey) ?>');
<?php endif ?>
<?php endif ?>
<?php if (!empty($behaviors)): ?>

<?php endif; ?>
<?php foreach ($behaviors as $behavior => $behaviorData): ?>
        $this->addBehavior('<?= $behavior ?>'<?= $behaviorData ? ", [" . implode(', ', $behaviorData) . ']' : '' ?>);
<?php endforeach ?>
        $this->addBehavior('Search.Search');
<?php if (!empty($associations)): ?>

<?php endif; ?>
<?php foreach ($associations as $type => $assocs): ?>
<?php foreach ($assocs as $assoc):
	$alias = $assoc['alias'];
	unset($assoc['alias']);
?>
        $this-><?= $type ?>('<?= $alias ?>', [<?= $this->Bake->stringifyList($assoc, ['indent' => 3]) ?>]);
<?php endforeach ?>
<?php endforeach ?>
    }
<?php if (!empty($validation)): ?>

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
<?php
foreach ($validation as $field => $rules):
    $validationMethods = [];
    foreach ($rules as $ruleName => $rule):
        if ($rule['rule'] && !isset($rule['provider'])):
            $validationMethods[] = sprintf(
                "->add('%s', '%s', ['rule' => '%s'])",
                $field,
                $ruleName,
                $rule['rule']
            );
        elseif ($rule['rule'] && isset($rule['provider'])):
            $validationMethods[] = sprintf(
                "->add('%s', '%s', ['rule' => '%s', 'provider' => '%s'])",
                $field,
                $ruleName,
                $rule['rule'],
                $rule['provider']
            );
        endif;

        if (isset($rule['allowEmpty'])):
            if (is_string($rule['allowEmpty'])):
                $validationMethods[] = sprintf(
                    "->allowEmpty('%s', '%s')",
                    $field,
                    $rule['allowEmpty']
                );
            elseif ($rule['allowEmpty']):
                $validationMethods[] = sprintf(
                    "->allowEmpty('%s')",
                    $field
                );
            else:
                $validationMethods[] = sprintf(
                    "->requirePresence('%s', 'create')",
                    $field
                );
                $validationMethods[] = sprintf(
                    "->notEmpty('%s')",
                    $field
                );
            endif;
        endif;
    endforeach;

    if (!empty($validationMethods)):
        $lastIndex = count($validationMethods) - 1;
        $validationMethods[$lastIndex] .= ';';
        ?>
        $validator
<?php foreach ($validationMethods as $validationMethod): ?>
            <?= $validationMethod ?>

<?php endforeach; ?>

<?php
    endif;
endforeach;
?>
        return $validator;
    }
<?php endif ?>
<?php if (!empty($rulesChecker)): ?>

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
<?php foreach ($rulesChecker as $field => $rule): ?>
        $rules->add($rules-><?= $rule['name'] ?>(['<?= $field ?>']<?= !empty($rule['extra']) ? ", '$rule[extra]'" : '' ?>));
<?php endforeach; ?>
        return $rules;
    }
<?php endif; ?>
<?php if ($connection !== 'default'): ?>

    /**
     * Returns the database connection name to use by default.
     *
     * @return string
     */
    public static function defaultConnectionName()
    {
        return '<?= $connection ?>';
    }
<?php endif; ?>

<?php
    $list = '';
    $exclude_list = ['password','created','modified','delete'];
    foreach($it_fields as $k=>$field):
        if(!in_array($k, $exclude_list)){
            $list .= '$this->aliasField(\''.$k.'\'), ';
        }
    endforeach;
?>
    // Configure how you want the search plugin to work with this table class
    public function searchConfiguration() {
        $search = new Manager($this);

        $fields = Configure::read('Admin.Tables.' . $this->alias() . '.header');
        
        $listFields = [];
        foreach ($fields as $field => $value) {
            if (isset($value['filter']) && $value['filter'] == 'text') {
                if ($this->aliasField($field)) {
                    $search->like($field, [
                        'before' => true,
                        'after' => true,
                        'field' => $this->aliasField($field)
                    ]);

                    $listFields[] = $this->aliasField($field);
                }
            } else if (isset($value['filter']) && $value['filter'] == 'list') {
                if ($this->aliasField($field)) {
                    $search->value($field, [
                        'field' => $this->aliasField($field),
                        'filterEmpty' => true
                    ]);
                }
            }
        }

        if (count($listFields) > 0) {
            $search->like('q', [
                'before' => true,
                'after' => true,
                'field' => $listFields
            ]);
        }

        if ($this->aliasField('delete')) {
            $search->value('trash', [
                'field' => $this->aliasField('delete')
            ]);
        }

        return $search;
    }
}
