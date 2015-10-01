<?php

App::import('Helper', 'Form');

class SemanticFormHelper extends FormHelper {

    public function __construct(\View $View, $settings = array()) {
        parent::__construct($View, $settings);
    }

    public function fieldClass($field) {
        return 'field ' . ($this->error($field) ? 'error' : '');
    }

    public function help($field) {
        if ($this->isFieldError($field)) {
            return '<div class="ui segment basic tiny text" style="color: #af4442; padding: 0px 4%;">
                <i class="icon large basic attention circle"></i>
                ' . $this->error($field) . '
            </div>';
        }
        return '';
    }

    public function input($fieldName, $options = array()) {
        $commons['label'] = false;
        $commons['error'] = false;
        return parent::input($fieldName, array_merge($commons, $options));
    }

    public function error($field, $options = array(), $text = NULL) {
        $commons['escape'] = false;
        $commons['wrap'] = false;
        return parent::error($field, $text, array_merge($commons, $options));
    }

}
