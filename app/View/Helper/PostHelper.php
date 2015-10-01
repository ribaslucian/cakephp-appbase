<?php

class PostHelper extends AppHelper {
    
    public $helpers = array('Form');

    protected $iconFormat = '<i {attributes}></i>';

    public function icon($icon, $url, array $options = array()) {
        @$options['class'] .= "icon $icon";
        return str_replace('{attributes}', $this->_parseAttributes($options), $this->iconFormat);
    }
    
    /**
     * Cria um formulário de envio de dados, 
     * focando na visualização apenas do botão de submit.
     * 
     * @param type $inputs
     * @param type $button
     * @param type $formOptions
     * 
     * @return <string> Html
     */
    public function button($inputs, $button, $formOptions = array()) {
        
        // Definindo alguns atributos padrão para o botão do formulário.
        $button = array_merge(array(
            'tag' => 'button',
            'type' => 'submit'
        ),$button);
        
        // Definindo nome do model que será atribuído ao formulário.
        //$model = $this->_View->controller->modelClass ?: 'PostButton';
        $model = 'PostButton';
        
        // Inicializando formulário.
        @$html .= $this->Form->create($model, $formOptions);
        
        // Percorrendo e criando inputs passados por parametro.
        foreach ($inputs as $field => $options)
            $html .= $this->Form->input($field, $options);
        
        // Definindo botão de submit.
        $html .= "<{$button['tag']} {$this->toAttr($button)}>{$button['text']}</{$button['tag']}>";
        
        // Fechando e retornando formulário 
        return $html . $this->Form->end();
    }
    
}
