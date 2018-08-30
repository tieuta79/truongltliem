<?php
namespace ItForms\View\Cell;

use Cake\View\Cell;

/**
 * ItForms cell
 */
class ItFormsCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Default display method.
     *
     * @return void
     */
    public function display($slug = null)
    {
        $this->loadModel('ItForms.Forms');
        $forms = $this->Forms->find()
                ->contain('Fields')
                ->where(['Forms.slug' => $slug]);
        if($forms->count() > 0){
            $fields = [];
            if(count($forms->first()->fields) > 0){
                foreach($forms->first()->fields as $k=>$field){
                    $fields[$field->slug] = [
                            'name' => 'form['.$field->id.'][value]',
                            'label' => ['text' => $field->name, 'class' => 'col-sm-2 control-label'],
                            'id' => $field->slug.'-'.$field->id,
                            'type' => $field->type
                        ];
                    
                    if($field->type=='select'){
                        $options = json_decode($field->options);
                        if (!empty($options)) {
                            $fields[$field->slug]['options'] = $options;
                        }else{
                            $fields[$field->slug]['options'] = [];
                        }
                    }
                    if(!empty($field->attributes)){
                        $attris = json_decode($field->attributes);
                         if (!empty($attris)) {
                            $fields[$field->slug] = Hash::merge( $fields[$field->slug],$attris);
                        }
                    }
                    if(!empty($field->value)){
                        $fields[$field->slug]['value'] = $field->value;
                    }
                }
            }
        }
        
        $this->set('fields', $fields);
        $this->set('forms', $forms->first());
    }
}
