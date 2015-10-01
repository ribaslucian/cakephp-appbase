<?php

class RefactorHelper extends AppHelper {

    public $helpers = array('Form');

    # Visão do âmbito corrente
    private $view;

    public function __construct(\View $View, $settings = array()) {
        parent::__construct($View, $settings);
        $this->view = &$View;
        $this->name = @$this->name[$this->request['controller']];
    }

    # Esta função retorna em formato de atributos das tags html, onde o
    # indice do array() $options é o atributo e seu valor o valor da tag

    public function get_attrs($commons = array(), $options = array()) {
        $attributes = '';
        foreach (array_merge($commons, $options) as $attribute => $value) {
            if ($attribute == 'required' || $attribute == 'autofocus') {
                $attributes .= $value ? $attribute : '';
                continue;
            }
            $attributes .= ' ' . $attribute . '="' . $value . '"';
        }
        return $attributes;
    }

    # Funções responsáveis pela criação pela aprensetação de alguns icones

    public function icon_empty($class = 'warning popup_hover purple', $options = array()) {
        $commons['data-position'] = 'top left';
        $commons['data-content'] = 'Nem um valor definido para esta campo.';
        return '<i class="icon ' . $class . '" ' . $this->get_attrs($commons, $options) . ' ></i> ';
    }

    public function buttonTo($name, $route, $id, $options = array(), $modelName = null) {
        $commons = array('type' => 'submit');
        $tag = @$options['tag'] ? : 'button';
        
        @$options['class'] .= ' pointer';

        $modelName = $modelName ?: $this->_modelScope;
        
        $html = $this->Form->create($modelName, array(
            'url' => $route,
            'method' => 'post',
            'target' => @$options['target'] ? : ''
        ));
        $html .= $this->Form->hidden('id', array('value' => $id));
        $html .= '<' . $tag . ' ' . $this->get_attrs($commons, $options) . '>' . $name . '</' . $tag . '>';
        $html .= $this->Form->end();

        return $html;
    }

}
