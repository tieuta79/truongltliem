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
 * @since         3.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Ittvn\Model\Behavior;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use ArrayObject;
use Cake\Utility\Inflector;
use Ittvn\Utility\System;
use Cake\I18n\I18n;
use Cake\Routing\Router;

class SluggableBehavior extends Behavior {

    /**
     * Default config
     * @var array
     */
    protected $_defaultConfig = [
        'field' => 'name',
        'slug' => 'slug',
        'replacement' => '-',
        'implementedFinders' => [
            'slugged' => 'findSlug',
        ]
    ];

    /**
     * implementedEvents
     *
     * The implemented events of this behavior depend on configuration
     *
     * @return array
     */
    public function implementedEvents() {
        return [
            'Model.beforeSave' => 'beforeSave'
        ];
    }

    /**
     * Initialize hook
     * @param array $config The config for this behavior.
     * @return void
     */
    public function initialize(array $config) {
        if (isset($config['fields'])) {
            $this->config('fields', $config['fields'], false);
        }
    }

    public function slug(Entity $entity) {
        $config = $this->config();
        $value = $entity->get($config['field']);
        $slug = $entity->get($config['slug']);
        if (empty($slug)) {
			$request = Router::getRequest();
			$lang = I18n::getLocale();
			if(!isset($request->query['lang']) || $request->query('lang') == $lang){
				$system = new System();
				$slug_value = $system->slug(mb_strtolower($value), $config['replacement']);
				$check_slug = $this->_table->find()->where(['slug LIKE' => $slug_value . '%'])->count();
				if (empty($check_slug)) {
					$entity->set($config['slug'], $slug_value);
				} else {
					$entity->set($config['slug'], $slug_value . '-' . $check_slug);
				}	
			}		
        }
    }

    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options) {
        $this->slug($entity);
    }

    public function findSlug(Query $query, array $options) {
        return $query->where(['slug' => $options['slug']]);
    }

}
