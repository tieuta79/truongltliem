<?php

return [
    'error' => '<small class="form-text text-muted text-danger error-message">{{content}}</small>',
    'inputContainer' => '<div class="form-group row {{type}}{{required}}">{{content}}</div>',
    'nestingLabel' => '<label{{attrs}} class="form-check form-check-inline">{{input}} {{text}}</label>',
    'inputContainerError' => '<div class="form-group row {type}}{{{required}} has-error">{{content}}{{error}}</div>',
    'checkboxWrapper' => '<div class="">{{label}}</div>',
    'input' => '<div class="col-xs-10"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
    'label' => '<label {{attrs}}>{{text}}</label>',
    'textarea' => '<textarea name="{{name}}"{{attrs}}>{{value}}</textarea>',
    'select' => '<select name="{{name}}"{{attrs}}>{{content}}</select>',
    'dateWidget' => '{{day}}{{month}}{{year}} {{hour}}{{minute}}{{second}} {{meridian}}',
    //'radioWrapper' => '<div class="radio">{{label}}</div>',
    //'checkboxWrapper' => '<div class="checkbox">{{label}}</div>',
    'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}> <i></i>',
    'radio' => '<input type="radio" name="{{name}}" value="{{value}}"{{attrs}}> <i></i>'
];
