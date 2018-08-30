<?php

namespace Templates\View\Helper;

use Cake\View\Helper;
use Cake\Utility\Hash;
use Cake\View\StringTemplateTrait;
use Cake\I18n\Time;
use Cake\Utility\Inflector;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Utility\Text;

class AdminHelper extends Helper {

    use StringTemplateTrait;

    protected $_defaultConfig = [
        'templates' => [
            'action' => '<div class="btn-group">{{action}}</div>',
        ],
    ];
    public $helpers = ['Paginator', 'Form', 'Html'];
    protected $_model_id = null;

    public function adminScript($view = 'index') {
        if (method_exists($this, '__adminScript' . ucfirst($view))) {
            $this->{'__adminScript' . ucfirst($view)}();
        }
    }

    private function __adminScriptIndex() {
        $scripts = [
            'plugin/datatables/jquery.dataTables.min',
            'plugin/datatables/dataTables.colVis.min',
            'plugin/datatables/dataTables.tableTools.min',
            'plugin/datatables/dataTables.bootstrap.min',
            'plugin/datatable-responsive/datatables.responsive.min',
        ];
        $this->Html->script($scripts, ['block' => 'scriptArea']);
    }

    private function __adminScriptForm() {
        $css = [
        ];
        $this->Html->css($css, ['block' => 'css']);

        $scripts = [
            //'plugin/summernote/summernote.min', //Select2
            //'plugin/markdown/markdown.min', //datepicker
            //'plugin/markdown/to-markdown.min', //datetimepicker
            //'plugin/markdown/bootstrap-markdown.min', //Wyswig Summernote Editor
            //'jquery.upload', // Upload AJAX
            'form'
        ];
        $this->Html->script($scripts, ['block' => 'scriptArea']);
    }

    private function __adminScriptMedia() {
        $css = [
            'jquery.contextMenu.min',
            'medias'
        ];
        $this->Html->css($css, ['block' => 'css']);

        $scripts = [
            'plugin/jquery-contextmenu/jquery.contextMenu.min',
            'plugin/jquery-contextmenu/jquery.ui.position.min',
            'plugin/dropzone/dropzone.min',
            'media'
        ];
        $this->Html->script($scripts, ['block' => 'scriptArea']);
    }

    private function __adminScriptFile() {
        $css = [
            'plugin/jsTree/style.min',
            'plugin/codemirror/codemirror',
            'plugin/codemirror/ambiance',
            'plugin/codemirror/addon/hint/show-hint',
        ];
        $this->Html->css($css, ['block' => 'css']);

        $scripts = [
            'plugin/jsTree/jstree.min',
            'plugin/codemirror/js/codemirror',
            'plugin/codemirror/addon/edit/matchbrackets',
            'plugin/codemirror/addon/hint/show-hint',
            'plugin/codemirror/addon/hint/css-hint',
            'plugin/codemirror/addon/hint/sql-hint',
            'plugin/codemirror/addon/hint/xml-hint',
            'plugin/codemirror/addon/hint/html-hint',
            'plugin/codemirror/addon/hint/javascript-hint',
            'plugin/codemirror/addon/hint/anyword-hint',
            'plugin/codemirror/mode/htmlmixed/htmlmixed',
            'plugin/codemirror/mode/xml/xml',
            'plugin/codemirror/mode/javascript/javascript',
            'plugin/codemirror/mode/css/css',
            'plugin/codemirror/mode/clike/clike',
            'plugin/codemirror/mode/php/php',
            'plugin/codemirror/mode/sql/sql',
            'file'
        ];
        $this->Html->script($scripts, ['block' => 'scriptArea']);
    }
    
    private function __adminScriptSlideshow() {
        $css = [
            'slideshow'
        ];
        //$this->Html->css($css, ['block' => 'css']);

        $scripts = [
            'slideshow'
        ];
        $this->Html->script($scripts, ['block' => 'scriptArea']);
    }

    private function __adminScriptMenu() {
        $scripts = [
            'plugin/jquery-nestable/jquery.nestable.min',
            'menu'
        ];
        $this->Html->script($scripts, ['block' => 'scriptArea']);
    }

    private function __adminScriptBlock() {
        $scripts = [
            //'plugins/nestable/jquery.nestable',
            //'jquery-ui.min',
            'block'
        ];
        $this->Html->script($scripts, ['block' => 'scriptArea']);
    }

    public function tableHeaderCheckbox() {
        return [
            'Checkbox' => [
                '<label class="toggle"><input type="checkbox" checked="checked" name="checkbox-toggle" /><i data-swchoff-text="OFF" data-swchon-text="ON"></i></label>' => [
                    'class' => 'action_check smart-form',
                    'name' => 'checkbox'
                ]
            ]
        ];
    }

    public function tableRowCheckbox($id = null, $array = true) {
        $input_checkbox = $this->Form->input('checkbox-' . $id, ['type' => 'checkbox', 'value' => $id, 'label' => false, 'templates' => ['inputContainer' => '<div class="smart-form"><label for="checkbox-' . $id . '" class="checkbox">{{content}}<i></i></label></div>']]);
        if ($array == false) {
            return $input_checkbox;
        }
        return [
            'Checkbox' => [
                $input_checkbox,
                    ['class' => 'action_check']
            ]
        ];
    }

    public function format($text, $type = null, $options = []) {
        $return = '';
        switch ($type) {
            case 'date':
                $return = $this->__formatDate($text, Configure::read('Settings.Times.date'));
                break;
            case 'datetime':
                $return = $this->__formatDate($text, Configure::read('Settings.Times.date') . ' ' . Configure::read('Settings.Times.time'));
                break;
            case 'timeago':
                $now = new Time($text);
                $return = $now->timeAgoInWords();
                break;
            default :
                break;
        }
        return $return;
    }

    private function __formatDate($date, $format = null) {
        $date_format = '';
        if (is_object($date) && get_class($date) == 'Cake\I18n\Time') {
            $date_format = $date->format($format);
        } else if (is_array($date)) {
            $date_arr = [];
            if (isset($date['year']) && isset($date['month']) && isset($date['day'])) {
                $date_arr[] = $date['year'] . '-' . $date['month'] . '-' . $date['day'];
            }

            if (isset($date['hour']) && isset($date['minute']) && isset($date['second'])) {
                $date_arr[] = $date['hour'] . ':' . $date['minute'] . ':' . $date['second'];
            }

            if (isset($date['meridian'])) {
                $date_arr[] = $date['meridian'];
            }
            $date_format = date($format, strtotime(implode(' ', $date_arr)));
        } else if (is_string($date)) {
            $date_format = date($format, strtotime($date));
        } else if (is_numeric($date)) {
            $date_format = date($format, $date);
        } else {
            $date_format = $date;
        }
        return $date_format;
    }

    public function formatText($text, $format = []) {
        if (empty($format)) {
            return $text;
        } else {
            switch ($format['type']) {
                case 'date':
                case 'datetime':
                    return $text->i18nFormat($format['text']);
                    break;
                case 'timeago':
                    $now = new Time($text);
                    return $now->timeAgoInWords();
                    break;
                case 'link':
                    if (isset($format['action']) && is_array($format['action'])) {
                        $format['action'] = urldecode(Router::url($format['action']));
                    }
                    $templater = $this->templater();
                    $templater->push();
                    $method = is_string($format) ? 'load' : 'add';
                    $templater->{$method}($format);

                    $action = $templater->format('action', [
                        'id' => $format['id']
                    ]);
                    return $templater->format('text', [
                                'action' => $action,
                                'attr' => $this->templater()->formatAttributes(['data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Edit') . ': ' . $text]),
                                'text' => $text
                    ]);
                    break;
                default:
                    break;
            }
        }
    }

    public function inputs($data = []) {
        $return = [];
        //pr($data); die();
        if (count($data) > 0):
            $default_options = ['class' => 'form-control'];
            foreach ($data as $field => $options):
                if (isset($options['type']) && $options['type'] == 'html') {
                    $return[] = $options['html'];
                } else {
                    if (is_string($field)) {
                        $options = Hash::merge($default_options, $options);
                        if (isset($options['type']) && ($options['type'] == 'file' || $options['type'] == 'checkbox' || $options['type'] == 'radio')) {
                            if ($options['type'] == 'file') {
                                $options['class'] = str_replace('form-control', '', $options['class']);
                            } else if ($options['type'] == 'checkbox') {
                                if (isset($options['templates'])) {
                                    $options['templates'] = Hash::merge(['inputContainer' => '<div class="form-group smart-form {{required}}">{{content}}</div>', 'nestingLabel' => '<label class="checkbox"{{attrs}}>{{hidden}}{{input}} {{text}}</label>',], $options['templates']);
                                } else {
                                    $options['templates'] = ['inputContainer' => '<div class="form-group smart-form {{required}}">{{content}}</div>', 'nestingLabel' => '<label class="checkbox"{{attrs}}>{{hidden}}{{input}} {{text}}</label>'];
                                }
                            } else if ($options['type'] == 'select') {
                                $options['style'] = 'width: 100%';
                            } else if ($options['type'] == 'radio') {
                                if (isset($options['templates'])) {
                                    $options['templates'] = Hash::merge(['inputContainer' => '<div class="form-group smart-form {{required}}">{{content}}</div>', 'nestingLabel' => '<label class="radio"{{attrs}}>{{hidden}}{{input}} {{text}}</label>'], $options['templates']);
                                } else {
                                    $options['templates'] = ['inputContainer' => '<div class="form-group smart-form {{required}}">{{content}}</div>', 'nestingLabel' => '<label class="radio"{{attrs}}>{{hidden}}{{input}} {{text}}</label>'];
                                }
                            }
                        } else if (isset($options['type']) && ($options['type'] == 'select_file' || $options['type'] == 'select_image')) {
                            $options['type'] = 'hidden';
                            $options['id'] = Text::uuid();
                            if (isset($options['templates'])) {
                                $options['templates'] = Hash::merge(['input' => '<input type="{{type}}" name="{{name}}"{{attrs}}/>' . $this->_View->element('Medias.input_image', ['return_element' => $options['id'], 'label' => isset($options['label']) ? $options['label'] : ''])], $options['templates']);
                            } else {
                                $options['templates'] = ['input' => '<input type="{{type}}" name="{{name}}"{{attrs}}/>' . $this->_View->element('Medias.input_image', ['return_element' => $options['id'], 'label' => isset($options['label']) ? $options['label'] : ''])];
                            }
                        } else if (isset($options['type']) && ($options['type'] == 'select_images')) {
                            $options['type'] = 'hidden';
                            $options['id'] = Text::uuid();
                            
                            if (isset($options['class'])) {
                                $options['class'] = $options['class'] . ' it_input_gallery';
                            } else {
                                $options['class'] = 'it_input_gallery';
                            }

                            //$options['templates'] = ['input' => '<input type="{{type}}" name="{{name}}"{{attrs}}/>' . $this->_View->element('Medias.input_images_list', ['field_name' => $field])];
                            $options['templates'] = ['input' => '<input type="{{type}}" name="{{name}}"{{attrs}}/>{{select_images}}'];
                            $options['templates']['input'] = str_replace('{{select_images}}', $this->_View->element('Medias.input_images', ['return_element' => $options['id'], 'field_name' => $field, 'label' => isset($options['label']) ? $options['label'] : '']), $options['templates']['input']);
                        } else if (isset($options['type']) && $options['type'] == 'select' && isset($options['multiple'])) {
                            if ($options['multiple'] == 'checkbox') {
                                if (isset($options['templates'])) {
                                    $options['templates'] = Hash::merge(['inputContainer' => '<div class="form-group smart-form {{required}}">{{content}}</div>', 'nestingLabel' => '<label class="checkbox"{{attrs}}>{{hidden}}{{input}} {{text}}</label>',], $options['templates']);
                                } else {
                                    $options['templates'] = ['inputContainer' => '<div class="form-group smart-form {{required}}">{{content}}</div>', 'nestingLabel' => '<label class="checkbox"{{attrs}}>{{hidden}}{{input}} {{text}}</label>'];
                                }
                            }
                        } else if (isset($options['type']) && $options['type'] == 'select') {
                            unset($options['class']);
                            $options['style'] = 'width:98%';
                        }

                        if (isset($options['options']) && is_string($options['options'])) {
                            if(isset($this->_View->viewVars[$options['options']])){
                                $options['options'] = $this->_View->viewVars[$options['options']];
                            }else{
                                $options['options'] = [];
                            }
                        }

                        if (isset($options['preview'])) {
                            $options = Hash::remove($options, 'preview');
                        }

                        if (isset($options['input-group']) && $options['input-group'] == true) {
                            $tmp_template = ['input' => '<div class="input-group">{{before-addon}}<input type="{{type}}" name="{{name}}"{{attrs}}/>{{after-addon}}</div>'];

                            $before_addon = isset($options['addon']['before']) ? '<div class="input-group-addon">' . $options['addon']['before'] . '</div>' : '';
                            $after_addon = isset($options['addon']['after']) ? '<div class="input-group-addon">' . $options['addon']['after'] . '</div>' : '';

                            $tmp_template['input'] = str_replace(array('{{before-addon}}', '{{after-addon}}'), array($before_addon, $after_addon), $tmp_template['input']);

                            if (isset($options['templates'])) {
                                $options['templates'] = Hash::merge($tmp_template, $options['templates']);
                            } else {
                                $options['templates'] = $tmp_template;
                            }
                            $options = Hash::remove($options, 'input-group');
                            $options = Hash::remove($options, 'addon');
                        }

                        if (isset($options['tooltip'])) {
                            $options['data-toggle'] = 'tooltip';
                            if (isset($options['tooltip']['html']) && $options['tooltip']['html'] == true) {
                                $options['data-html'] = 'true';
                            }
                            if (isset($options['tooltip']['title'])) {
                                $options['title'] = __d('ittvn', $options['tooltip']['title']);
                            }
                            $options = Hash::remove($options, 'tooltip');
                        }

                        if (isset($options['inputmask']) && isset($options['inputmask']['alias'])) {
                            $options['data-inputmask'] = '"alias":' . '"' . $options['inputmask']['alias'] . '"';
                            $options['data-mask'] = '';
                            $options = Hash::remove($options, 'inputmask');
                        }

                        if (isset($options['format'])) {
                            $singularize = strtolower(Inflector::singularize($this->request->controller));
                            if (isset($this->_View->viewVars[$singularize]->{$field})) {
                                $options['value'] = $this->formatText($this->_View->viewVars[$singularize]->{$field}, $options['format']);
                            }
                            $options = Hash::remove($options, 'format');
                        }

                        if (isset($options['label']) && $options['label'] != false) {
                            $options['label'] = __d('ittvn', $options['label']);
                        }

                        $return[] = $this->Form->input($field, $options);
                    } else {
                        $return[] = $this->Form->input($options, $default_options);
                    }
                }
            endforeach;
        endif;
        return implode('', $return);
    }

    public function view($label, $value, $type = null) {
        $label = $this->Html->tag('strong', $label);
        switch ($type) {
            case 'image':
                if (!empty($value)) {
                    $value = $this->Html->tag('dd', $value, ['class' => 'project-people']);
                }
                $view = $this->Html->tag('dt', $label) . ' ' . $value;
                break;
            default:
                if (!empty($value)) {
                    $value = $this->Html->tag('dd', $value);
                }
                $view = $this->Html->tag('dt', $label) . ' ' . $value;
                break;
        }
        return $view;
    }

    public function urlTrash($trash = true, $options = []) {
        $url = [];
        $url = ['plugin' => $this->request->plugin, 'controller' => $this->request->controller, 'action' => $this->request->action];
        $url = Hash::merge($url, $this->request->params['pass']);
        if ($trash == true) {
            $url = Hash::merge($url, ['trash' => 1]);
        }
        $url = Hash::merge($url, $options);
        return $url;
    }

    public function galleries($galleries = [], $deep = 0, $element = 'Medias.galleries') {
        $tree = '<ul>';
        if ($deep == 0) {
            $tree .= '<li id="tree_root" data-path="' . __d('ittvn', 'Root') . '" data-id="0"><span class="active-node"><i class="fa fa-lg fa fa-home"></i> ' . __d('ittvn', 'Root') . '</span><ul>';
        }
        foreach ($galleries as $gallery) {
            $tree .= $this->_View->element($element, ['gallery' => $gallery, 'deep' => $deep]);
        }

        if ($deep == 0) {
            $tree .= '</ul>';
        }
        $tree .= '</ul>';
        return $tree;
    }

}
