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

    # Atribuir JS's de gráfico apenas na página inicial.
    if ($this->name == 'Management') {
        echo $this->Html->script(array(
            '../jqplot/jquery.jqplot.min',
            '../jqplot/plugins/jqplot.categoryAxisRenderer.min',
            '../jqplot/plugins/jqplot.highlighter.min',
            '../jqplot/plugins/jqplot.canvasTextRenderer.min',
            '../jqplot/plugins/jqplot.canvasAxisTickRenderer.min',
            '../jqplot/plugins/jqplot.barRenderer.min',
            '../jqplot/plugins/jqplot.pointLabels.min',
        ));
    }
}

echo $this->Html->script(array(
    'app/' . strtolower($this->name . '/' . $this->action),
    'app/initialize'
));
