<?php

namespace Contents\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Core\Configure;
use Ittvn\Utility\System;
use Settings\Utility\Setting;
use Metas\Utility\Metas;
use Cake\Utility\Text;
use Ittvn\Utility\Language;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Core\App;

class ContentsEventHandler implements EventListenerInterface {

    public function implementedEvents() {
        return [
            //'Admin.Categories.Tables.SelectBoxAction' => 'addFilterSelects',
            'Admin.Tables.Contents.header' => 'header',
            'Admin.Tables.Contents.filterHeader' => 'filterHeader',
            'Admin.Tables.Contents.row' => 'addRow',
            'Admin.Forms.Contents.main' => 'formMain',
            'Admin.Forms.Contents.sidebar' => 'formSidebar',
            'Admin.Views.Contents' => 'view',
            'Admin.Tables.Contents.rowAction' => 'rowAction'
        ];
    }

    public function addFilterSelects(Event $event) {

        $filterSelects = $event->subject()['filterSelects'];
        if (!empty($event->result)) {
            $filterSelects = $event->result;
        }

        $filterSelects['ParentCategories'] = [
            'label' => 'Parent Category',
            'name' => 'parent_id',
            'fields' => ['id', 'name']
        ];
        return $filterSelects;
    }

    public function header(Event $event) {
        $headers = $event->subject()['header'];
        $headers['translate'] = ['label' => 'Translate', 'sort' => 1, 'filter' => 'text', 'data-class' => 'expand'];

        $request = Router::getRequest();
        $metaType = TableRegistry::get('Metas.MetaTypes')->find()->find('network')->where(['slug' => $request->params['pass'][0]])->first();
        if ($request->params['pass'][0] == 'pages') {
            unset($headers['excerpt']);
        }
        if ($metaType->category == 1) {
            $h = [];

            $metaCategories = TableRegistry::get('Metas.MetaCategories')->findByMetaTypeId($metaType->id)->select(['id', 'name', 'slug'])->find('network');
            $he = [];
            foreach ($metaCategories as $metaCategory) {
                $metaCatVariable = Inflector::variable($metaCategory->name);
                $he[$metaCatVariable] = ['label' => $metaCategory->name, 'sort' => false, 'filter' => 'list', 'data-hide' => 'phone,tablet'];
            }

            /*
              Configure::write('Admin.Tables.Contents.header', Hash::merge(Configure::read('Admin.Tables.Contents.header'), [
              'category_id' => [
              'label' => __d('ittvn', 'Category_id'),
              'sort' => false,
              'filter' => 'list',
              'data-hide' => 'phone,tablet'
              ]
              ]));
             * 
             */

            foreach ($headers as $key => $header) {
                $h[$key] = $header;
                if ($key == 'excerpt') {
                    $h = Hash::merge($h, $he);
                }
            }

            return $h;
        } else {
            return $headers;
        }
    }

    public function filterHeader(Event $event) {
        $filters = $event->subject()['filter'];
        $request = Router::getRequest();
        $metaType = TableRegistry::get('Metas.MetaTypes')->find()->find('network')->where(['slug' => $request->params['pass'][0]])->first();
        if ($metaType->category == 1) {
            $h = [];

            $metaCategories = TableRegistry::get('Metas.MetaCategories')->findByMetaTypeId($metaType->id)->select(['id', 'name', 'slug'])->find('network');
            $he = [];
            foreach ($metaCategories as $metaCategory) {
                $he[Inflector::variable($metaCategory->name)] = TableRegistry::get('Contents.Categories')->find('network')->find('treeList', ['spacer' => '------'])->where(['meta_category_id' => $metaCategory->id]);
            }

            foreach ($filters as $key => $filter) {
                if (isset($he[$key])) {
                    $options = '';
                    foreach ($he[$key] as $kcat => $cat) {
                        $options .= '<option value="' . $kcat . '">' . $cat . '</option>';
                    }
                    $filters[$key] = [
                        '<label class="select"><select class="form-control" style="width: 100%;"><option value="">Filter ' . $key . '</option>' . $options . '</select><i></i></label>' => [
                            'class' => 'hasinput smart-form'
                        ]
                    ];
                }
            }
        }
        return $filters;
    }

    public function addRow(Event $event) {
        $headers = $event->subject()['header'];
        $col_category = 4;
        $row = $event->subject()['row'];
        $helper = $event->subject()['helper'];
        $request = Router::getRequest();

        $result = $event->subject()['data'];
        if (!empty($event->result)) {
            $result = $event->result;
        }

        $CategoryContents = TableRegistry::get('Contents.CategoryContents');
        $Categories = TableRegistry::get('Contents.Categories');

        $metaCategories = TableRegistry::get('Metas.MetaCategories')->findByMetaTypeId($row->meta_type_id)->find('network')->select(['id', 'name', 'slug']);
        foreach ($metaCategories as $metaCategory) {
            $metaCatVariable = Inflector::variable($metaCategory->name);

            if (in_array($metaCatVariable, $headers)) {
                $category_ids = $Categories->find('list')->find('network')->select(['name', 'id'])->where(['meta_category_id' => $metaCategory->id])->toArray();
                if (count($category_ids) > 0) {
                    $category_ids = array_keys($category_ids);

                    $categoryContents = $CategoryContents->find()->find('network')->select(['id', 'category_id'])->where(['CategoryContents.content_id' => $row->id, 'CategoryContents.category_id IN' => $category_ids])->toArray();
                    $categoryContents = Hash::extract($categoryContents, '{n}.category_id');
                    if (count($categoryContents) > 0) {
                        $categories = $Categories->find()->find('network')->select(['id', 'name'])->where(['Categories.id IN' => $categoryContents])->toArray();
                        foreach ($categories as $category) {
                            $result[$col_category][] = '<span filter_id="' . $category->id . '">' . $category->name . '</span>';
                        }
                        //$result[$col_category] = implode('<br />', $result[$col_category]);
                        $result[$col_category] = Text::toList($result[$col_category], '<br />', '<br />');
                    } else {
                        $result[$col_category] = '';
                    }
                } else {
                    $result[$col_category] = '';
                }
            } else {
                $result[$col_category] = '';
            }
            $col_category++;
        }



        foreach ($headers as $key => $field) {
            switch ($field) {
                case 'name':
                    if (!empty($row->image)) {
                        $result[$key] = $helper->Html->image($row->image, ['width' => 50, 'class' => 'img-thumbnail']) . ' ';
                    } else {
                        $result[$key] = '';
                    }

                    $result[$key] .= $helper->Html->link($row->name, ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'edit', $row->id, $request->params['pass'][0]], ['data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Edit') . ': ' . $row->name]);
                    break;
                case 'excerpt':
                    $result[$key] = Text::excerpt($row->excerpt, 'method', 100, '...');
                    break;
                case 'translate':
                    $default_lang = ini_get('intl.default_locale');
                    //$languages = TableRegistry::get('Extensions.Languages')->find()->find('network')->where(['status' => 1]);                    
                    if (Language::getLanguages()->count() > 1) {
                        $languages = Language::$languages;
                        $i = 0;
                        foreach ($languages as $language) {
                            if ($language['code'] != $default_lang) {
                                $nameclass = "flag " . $language['class'];
                                $result[$key][$i] = $helper->Html->image("/templates/img/blank.gif", [
                                    "class" => $nameclass,
                                    "alt" => $language['name'],
                                    'url' => ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'edit_language', $row->id, $request->params['pass'][0], 'lang' => $language['code']]
                                ]);
                                //$result[$key][$i] = <img src="/templates/img/blank.gif" class="flag '.$language['class'].'" alt="'.$language['name'].'">';
                                $i++;
                            }
                        }
                    }
            }
        }

        return $result;
    }

    function rowAction(Event $event) {
        $action = $event->subject()['action'];
        $row = $event->subject()['row'];
        $helper = $event->subject()['helper'];
        $request = Router::getRequest();

        $action['Edit'] = $helper->Html->link(
                '<i class="fa fa-pencil-square-o"></i>', ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'edit', $row->id, $request->params['pass'][0]], ['escape' => false, 'class' => 'btn btn-success btn-xs', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Edit')]
        );

        $action['Delete'] = $helper->Form->postLink(
                '<i class="fa fa-trash-o"></i>', ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'delete', $row->id, $request->params['pass'][0]], ['escape' => false, 'class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Delete'), 'confirm' => __d('ittvn', 'Are you sure you want to delete # {0}?', $row->id)]
        );

        $action['View'] = $helper->Html->link(
                '<i class="fa fa-arrows-alt"></i>', ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'slug' => $row->slug, 'type' => $request->params['pass'][0], 'prefix' => false], ['escape' => false, 'class' => 'btn btn-info btn-xs', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'View'), 'target' => '_blank']
        );
        return $action;
    }

    public function formMain(Event $event) {
        $blocks = $event->subject()['blocks'];
        $helper = $event->subject()['helper'];
        $viewVars = $event->subject()['viewVars'];
        $request = Router::getRequest();

        if (!empty($event->result)) {
            $blocks = $event->result;
        }

        //check show/hide
        $metaTypeSlug = '';
        if ($request->action == 'add') {
            $metaTypeSlug = $request->params['pass'][0];
        } else if ($request->action == 'edit') {
            $metaTypeSlug = $request->params['pass'][1];
        } else if ($request->action == 'editLanguage') {
            $metaTypeSlug = $request->params['pass'][1];
            $setting = new Setting();
            $fileds = json_decode($setting->getOption('Translation.Contents'), true);
            $field_meta = json_decode($setting->getOption('Translation.ExtraFields'), true);
            if (!empty($field_meta)) {
                foreach ($field_meta as $value) {
                    if (!in_array($value, $field_meta)) {
                        unset($blocks['default'][$value]);
                    }
                }
            }
            if (!empty($fileds)) {
                if (!in_array('excerpt', $fileds)) {
                    unset($blocks['default']['excerpt']);
                }
                if (!in_array('slug', $fileds)) {
                    unset($blocks['default']['slug']);
                }
                if (!in_array('name', $fileds)) {
                    unset($blocks['default']['name']);
                }
                if (!in_array('description', $fileds)) {
                    unset($blocks['default']['description']);
                }
            }
        }
        $metaTypes = TableRegistry::get('Metas.MetaTypes')->find()->find('network')->select(['id', 'options'])->where(['slug' => $metaTypeSlug]);

        if ($metaTypes->toArray() > 0) {
            $options = $metaTypes->first()->options;
            foreach ($options as $k => $v) {
                if (!empty($v)) {
                    switch ($k) {
                        case 'hideExcerpt':
                            unset($blocks['default']['excerpt']);
                            break;
                        case 'hideDescription':
                            unset($blocks['default']['description']);
                            break;
                    }
                }
            }
        }

        // Add Extra Fields
        $metas = (new Metas())->parseform();

        if (count($metas) > 0) {
            $metas['label'] = 'Extra Fields';
            $blocks['extra_fields'] = $metas;
        }
        //End add extra fields

        return $blocks;
    }

    public function formSidebar(Event $event) {
        $blocks = $event->subject()['blocks'];
        $helper = $event->subject()['helper'];
        $viewVars = $event->subject()['viewVars'];
        $request = Router::getRequest();

        if (!empty($event->result)) {
            $blocks = $event->result;
        }

        //check show/hide
        $metaTypeSlug = '';
        if ($request->action == 'add') {
            $metaTypeSlug = $request->params['pass'][0];
        } else if ($request->action == 'edit') {
            $metaTypeSlug = $request->params['pass'][1];
        } else {
            $metaTypeSlug = $request->params['pass'][1];
        }
        $metaType = TableRegistry::get('Metas.MetaTypes')->find()->find('network')->where(['slug' => $metaTypeSlug])->first();
        if (!empty($metaType)) {
            $options = $metaType->options;
            foreach ($options as $k => $v) {
                if (!empty($v)) {
                    switch ($k) {
                        case 'hideFeatureImage':
                            unset($blocks['image']);
                            break;
                    }
                }
            }
        }

        if (isset($blocks['action']['layout'])) {
            $setting = new Setting();
            $currTheme = $setting->getOption('Themes.site');
            $pathLayout = App::path('Template/Layout', $currTheme)[0];
            $folder = new Folder($pathLayout);
            $files = $folder->read();
            if (isset($files[1]) && count($files[1]) > 0) {
                foreach ($files[1] as $file) {
                    $filename = str_replace('.ctp', '', $file);
                    $blocks['action']['layout']['options'][$filename] = Inflector::humanize($filename);
                }
            }
        }

        if ($metaTypeSlug != 'pages') {
            if (empty($options['hideFeatured'])) {
                $block_action = [];
                if (isset($blocks['action']['label'])) {
                    $block_action['label'] = $blocks['action']['label'];
                }

                $block_action['featured'] = ['type' => 'checkbox'];

                if (isset($blocks['action']['status'])) {
                    $block_action['status'] = $blocks['action']['status'];
                }

                if (isset($blocks['action']['layout'])) {
                    $block_action['layout'] = $blocks['action']['layout'];
                }

                if (isset($blocks['action']['modified'])) {
                    $block_action['modified'] = $blocks['action']['modified'];
                }

                $blocks['action'] = $block_action;
            }
        }

        if ($metaType->category == 1) {
            $metaCategories = TableRegistry::get('Metas.MetaCategories')->findByMetaTypeId($metaType->id)->find('network')->select(['id', 'name', 'slug']);

            if ($request->action == 'edit') {
                $value = TableRegistry::get('Contents.CategoryContents')->find('list', ['keyField' => 'category_id', 'valueField' => 'category_id'])->find('network')->where(['content_id' => $request->params['pass'][0]])->toArray();
            }

            foreach ($metaCategories as $metaCategory) {
                $metaCatVariable = Inflector::variable($metaCategory->name);

                $blocks[$metaCategory->slug] = [
                    'label' => $metaCategory->name,
                    $metaCatVariable . '.id' => [
                        'label' => '',
                        'options' => $metaCatVariable
                    ]
                ];
                if ($metaType->multi_category == 1) {
                    $blocks[$metaCategory->slug][$metaCatVariable . '.id']['type'] = 'select';
                    $blocks[$metaCategory->slug][$metaCatVariable . '.id']['multiple'] = 'checkbox';
                } else {
                    $blocks[$metaCategory->slug][$metaCatVariable . '.id']['type'] = 'radio';
                    $blocks[$metaCategory->slug][$metaCatVariable . '.id']['multiple'] = false;
                }

                if (isset($value)) {
                    $blocks[$metaCategory->slug][$metaCatVariable . '.id']['value'] = $value;
                }
            }
        }

        return $blocks;
    }

    public function view(Event $event) {
        $fields = $event->subject()['fields'];
        $views = $event->subject()['views'];
        $helper = $event->subject()['helper'];

        foreach ($fields as $key => $field) {
            switch ($key) {
                case 'image':
                    if (!empty($views->image)) {
                        $fields[$key]['value'] = $helper->view($field['label'], $helper->Html->image($views->image, ['width' => 50]));
                    }
                    break;
                case 'excerpt':
                    $fields[$key]['value'] = $helper->view($field['label'], $views->excerpt);
                    //show more categories
                    $fields['categories']['label'] = 'Categories';
                    $categoryContents = TableRegistry::get('Contents.CategoryContents')->find('network')->find('list')->select(['id', 'category_id'])->where(['content_id' => $views->id])->toArray();
                    if (count($categoryContents) > 0) {
                        $categoryContents = array_values($categoryContents);
                        $categories = TableRegistry::get('Contents.Categories')->find('list')->find('network')->select(['id', 'name'])->where(['id IN' => $categoryContents])->toArray();
                        $fields['categories']['value'] = $helper->view($fields['categories']['label'], implode('<br />', $categories));
                    } else {
                        $fields['categories']['value'] = $helper->view($fields['categories']['label'], '');
                    }
                    break;
                default:
                    break;
            }
        }
        return $fields;
    }

}
