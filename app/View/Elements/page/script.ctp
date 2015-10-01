<?php

// Scripts que são necessários em qualquer área do sistema.
echo $this->Html->script(array(
    // Aglomerado de classes primitivas ou baixadas.
    'primitive/agglomerate',
    '../semantic/semantic.min',
    // Importando configuração das bibliotecas jQuery
    'app/config'
));

// Scripts que são necessários apenas se o usuário estiver logado.
if (AuthComponent::user('id')) {
    echo $this->Html->script(array(
        // funções criadas neste contexto
        'app/functions',
        'lib/multi_upload',
        'lib/table_select_rows',
        'lib/input_clone',
        'lib/pagination',
            // 'lib/local_filter',
            // 'lib/cart',
    ));
}

echo $this->Html->script(array(
    'app/' . strtolower($this->name . '/' . $this->action),
    'app/initialize'
));
