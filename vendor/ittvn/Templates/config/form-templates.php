<?php

return [
    'error' => '<p class="help-block text-danger error-message">{{content}}</p>',
    'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
    'nestingLabel' => '<label{{attrs}}>{{input}} {{text}}</label>',
    'inputContainerError' => '<div class="form-group {type}}{{{required}} has-error">{{content}}{{error}}</div>',
    'checkboxWrapper' => '<div class="">{{label}}</div>',
    'input' => '<input type="{{type}}" name="{{name}}"{{attrs}}/>',
    'label' => '<label {{attrs}}>{{text}}</label>',
    'textarea' => '<textarea name="{{name}}"{{attrs}}>{{value}}</textarea>',
    'select' => '<select name="{{name}}"{{attrs}}>{{content}}</select>',
    'dateWidget' => '{{day}}{{month}}{{year}} {{hour}}{{minute}}{{second}} {{meridian}}',
    //'radioWrapper' => '<div class="radio">{{label}}</div>',
    //'checkboxWrapper' => '<div class="checkbox">{{label}}</div>',
    'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}> <i></i>',
    'radio' => '<input type="radio" name="{{name}}" value="{{value}}"{{attrs}}> <i></i>'
];
