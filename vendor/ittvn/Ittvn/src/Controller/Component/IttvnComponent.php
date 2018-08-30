<?php

namespace Ittvn\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\Event;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Core\Configure;
use Cake\Core\App;
use Cake\Utility\Inflector;
use Settings\Utility\Setting;
use Cake\Datasource\ConnectionManager;

class IttvnComponent extends Component {

    protected $plugin = false;

    public function initialize(array $config = []) {
        if (isset($this->request->plugin) && !empty($this->request->plugin)) {
            $this->plugin = $this->request->plugin;
        }
        //pr($this->themes());
        //die();
    }

    public function startup(Event $event) {
        
    }

    public function beforeFilter(Event $event) {
        if ($this->request->prefix == 'admin' && isset($this->request->query['action_table']) && !empty($this->request->query['action_table'])) {
            if (!empty($this->request->query['action_table_value'])) {

                $ids = explode(',', $this->request->query['action_table_value']);
                $action = [
                    'action' => $this->request->query['action_table'],
                    'ids' => $ids
                ];

                if (method_exists($event->subject(), 'action')) {
                    $event->subject()->action($action);
                } else {
                    if (empty($this->plugin) || $this->plugin == false) {
                        $model = $event->subject()->loadModel($event->subject()->name);
                    } else {
                        $model = $event->subject()->loadModel($this->plugin . '.' . $event->subject()->name);
                    }
                    switch ($action['action']) {
                        case 'trash':
                            $return = $model->updateAll(['`delete`' => 1], [$model->primaryKey() . ' IN' => $action['ids']]);
                            if ($return) {
                                $event->subject()->Flash->success(__('Items is move to trash.'));
                            } else {
                                $event->subject()->Flash->error(__('Items is not move to trash. Please, try again.'));
                            }
                            break;
                        case 'untrash':
                            $return = $model->updateAll(['`delete`' => 0], [$model->primaryKey() . ' IN' => $action['ids']]);
                            if ($return) {
                                $event->subject()->Flash->success(__('Items is untrash.'));
                            } else {
                                $event->subject()->Flash->error(__('Items is error untrash. Please, try again.'));
                            }
                            break;
                        case 'delete':
                            $return = $model->deleteAll(function ($exp, $q) use ($model, $action) {
                                return $exp->in($model->primaryKey(), $action['ids']);
                            });
                            if ($return) {
                                $event->subject()->Flash->success(__('Items is deleted.'));
                            } else {
                                $event->subject()->Flash->error(__('Items is not delete. Please, try again.'));
                            }
                            break;

                        default:
                            break;
                    }
                }
            }
            $event->subject()->redirect($event->subject()->referer());
        }
    }

    public function plugins($fullpath = false) {
        $dir = new Folder(ROOT . DS . 'plugins');
        return $dir->read(true, false, $fullpath)[0];
    }

    public function themes() {
        $plugins = $this->plugins(true);
        $themes = [];
        if (count($plugins) > 0) {
            $dir = new Folder();
            foreach ($plugins as $key => $folder) {
                $dir->cd($folder);
                $file = $dir->findRecursive('template.json');
                if (!empty($file)) {
                    $file = new File($file[0]);
                    $themes[$folder] = json_decode($file->read());
                }
            }
        }
        return $themes;
    }

    public function findHasMany($model = null, $associations) {
        $schema = $model->schema();
        $primaryKey = (array) $schema->primaryKey();
        $tableName = $schema->name();
        $foreignKey = $this->__modelKey($tableName);

        foreach ($this->__getAllTables() as $otherTable) {
            $otherModel = $this->__getTableObject(Inflector::camelize($otherTable), $otherTable);
            $otherSchema = $otherModel->schema();

            // Exclude habtm join tables.
            $pattern = '/_' . preg_quote($tableName, '/') . '|' . preg_quote($tableName, '/') . '_/';
            $possibleJoinTable = preg_match($pattern, $otherTable);
            if ($possibleJoinTable) {
                continue;
            }

            foreach ($otherSchema->columns() as $fieldName) {
                $assoc = false;
                if (!in_array($fieldName, $primaryKey) && $fieldName === $foreignKey) {
                    $assoc = [
                        'alias' => $otherModel->alias(),
                        'foreignKey' => $fieldName
                    ];
                } elseif ($otherTable === $tableName && $fieldName === 'parent_id') {
                    $className = ($this->request->plugin) ? $this->request->plugin . '.' . $model->alias() : $model->alias();
                    $assoc = [
                        'alias' => 'Child' . $model->alias(),
                        'className' => $className,
                        'foreignKey' => $fieldName
                    ];
                }
                if ($assoc && $this->request->plugin && empty($assoc['className'])) {
                    $assoc['className'] = $this->request->plugin . '.' . $assoc['alias'];
                }
                if ($assoc) {
                    $associations['hasMany'][] = $assoc;
                }
            }
        }
        return $associations;
    }

    public function findBelongsTo($model, $associations) {
        $schema = $model->schema();
        foreach ($schema->columns() as $fieldName) {
            if (!preg_match('/^.*_id$/', $fieldName)) {
                continue;
            }

            if ($fieldName === 'parent_id') {
                $className = ($this->request->plugin) ? $this->request->plugin . '.' . $model->alias() : $model->alias();
                $assoc = [
                    'alias' => 'Parent' . $model->alias(),
                    'className' => $className,
                    'foreignKey' => $fieldName
                ];
            } else {
                $key = str_replace('_id', '', $fieldName);
                $tmpModelName = Inflector::camelize(Inflector::pluralize($key));
                if (!in_array(Inflector::tableize($tmpModelName), $this->__getAllTables())) {
                    $found = $this->__findTableReferencedBy($schema, $fieldName);
                    if ($found) {
                        $tmpModelName = Inflector::camelize($found);
                    }
                }
                $assoc = [
                    'alias' => $tmpModelName,
                    'foreignKey' => $fieldName
                ];
                if ($schema->column($fieldName)['null'] === false) {
                    $assoc['joinType'] = 'INNER';
                }
            }

            if ($this->request->plugin && empty($assoc['className'])) {
                $assoc['className'] = $this->request->plugin . '.' . $assoc['alias'];
            }

            $assoc['schema'] = $model->{$assoc['alias']}->schema();
            $assoc['displayField'] = $model->{$assoc['alias']}->displayField();

            $associations['belongsTo'][] = $assoc;
        }
        return $associations;
    }

    public function findBelongsToMany($model, $associations) {
        $schema = $model->schema();
        $tableName = $schema->name();
        $foreignKey = $this->__modelKey($tableName);

        $tables = $this->__getAllTables();
        foreach ($tables as $otherTable) {
            $assocTable = null;
            $offset = strpos($otherTable, $tableName . '_');
            $otherOffset = strpos($otherTable, '_' . $tableName);

            if ($offset !== false) {
                $assocTable = substr($otherTable, strlen($tableName . '_'));
            } elseif ($otherOffset !== false) {
                $assocTable = substr($otherTable, 0, $otherOffset);
            }
            if ($assocTable && in_array($assocTable, $tables)) {
                $habtmName = Inflector::camelize($assocTable);
                $assoc = [
                    'alias' => $habtmName,
                    'foreignKey' => $foreignKey,
                    'targetForeignKey' => $this->__modelKey($habtmName),
                    'joinTable' => $otherTable
                ];
                if ($assoc && $this->request->plugin) {
                    $assoc['className'] = $this->request->plugin . '.' . $assoc['alias'];
                }

                $assoc['schema'] = $model->{$assoc['alias']}->schema();

                $associations['belongsToMany'][] = $assoc;
            }
        }
        return $associations;
    }

    private function __getTableObject($className, $table) {
        if (\Cake\ORM\TableRegistry::exists($className)) {
            return \Cake\ORM\TableRegistry::get($className);
        }
        return \Cake\ORM\TableRegistry::get($className, [
                    'name' => $className,
                    'table' => $table,
                    'connection' => ConnectionManager::get('default')
        ]);
    }

    private function __modelKey($name) {
        list(, $name) = pluginSplit($name);
        return Inflector::underscore(Inflector::singularize($name)) . '_id';
    }

    private function __getAllTables() {
        $db = ConnectionManager::get('default');
        if (!method_exists($db, 'schemaCollection')) {
            $this->err(
                    'Connections need to implement schemaCollection() to be used with bake.'
            );
            return $this->_stop();
        }
        $schema = $db->schemaCollection();
        $tables = $schema->listTables();
        if (empty($tables)) {
            $this->err('Your database does not have any tables.');
            return $this->_stop();
        }
        sort($tables);
        return $tables;
    }

    private function __findTableReferencedBy($schema, $keyField) {
        if (!$schema->column($keyField)) {
            return null;
        }
        foreach ($schema->constraints() as $constraint) {
            $constraintInfo = $schema->constraint($constraint);
            if (in_array($keyField, $constraintInfo['columns'])) {
                if (!isset($constraintInfo['references'])) {
                    continue;
                }
                return $constraintInfo['references'][0];
            }
        }
        return null;
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event) {
        $setting = new Setting();
        $template_site = $setting->getOption('Themes.site');
        $template_admin = $setting->getOption('Themes.admin');

        if (!empty($template_site) && $event->subject()->request->prefix == false) {
            $event->subject()->viewBuilder()->theme($template_site);
        }


        if ($event->subject()->request->prefix == 'admin') {
            if (empty($template_admin)) {
                $template_admin = 'Templates';
            }
            $event->subject()->viewBuilder()->theme($template_admin);
            if ($this->checkViewClass('Admin', $template_admin)) {
                $event->subject()->viewClass = $template_admin . '.Admin';
            } else {
                $event->subject()->viewClass = 'Ittvn.Admin';
            }

            if ($this->checkHelper('Layout', $template_admin)) {
                $event->subject()->helpers([$template_admin . '.Layout']);
            } else {
                $event->subject()->viewBuilder()->helpers(['Ittvn.Layout']);
            }
        } else {
            if (empty($template_site)) {
                $template_site = 'Templates';
            }
            $event->subject()->viewBuilder()->theme($template_site);
            if ($this->checkViewClass('App', $template_site)) {
                $event->subject()->viewClass = $template_site . '.App';
            } else {
                $event->subject()->viewClass = 'Ittvn.App';
            }

            if ($this->checkHelper('Layout', $template_site)) {
                $event->subject()->viewBuilder()->helpers([$template_admin . '.Layout']);
            } else {
                $event->subject()->viewBuilder()->helpers(['Ittvn.Layout']);
            }
        }
    }

    private function checkViewClass($viewClass, $plugin = null) {
        $path = App::path('View', $plugin);
        if (count($path) > 0) {
            if (file_exists($path[0] . $viewClass . 'View.php')) {
                return true;
            }
        }
        return false;
    }

    private function checkHelper($helper, $plugin = null) {
        $path = App::path('View/Helper', $plugin);
        if (count($path) > 0) {
            if (file_exists($path[0] . $helper . 'Helper.php')) {
                return true;
            }
        }
        return false;
    }

}
