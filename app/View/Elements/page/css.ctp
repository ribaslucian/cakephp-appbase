<?php

// Requisição dos css da aplicação
echo $this->Html->css(array(
    // Requisição dos componentes do framework front-end.
    '../semantic/semantic.min',
    // Requisição dos estilos básicos da aplicação.
    'font/open-sans/css',
    'app/style',
        ), 'stylesheet', array('media' => 'all')
);

// Requisiçao dos estilos das bibliotecas jquery customizadas.
// necessário apenas se o usuário estive conectado.
if (AuthComponent::user('id')) {
    echo $this->Html->css(array(
        'lib/multi_upload'
            ), 'stylesheet', array('media' => 'all')
    );

    # Atribuir CSS's de gráfico apenas na página inicial.
    if ($this->name == 'Management') {
        echo $this->Html->css(array(
            '../jqplot/jquery.jqplot.min'
        ));
    }
}