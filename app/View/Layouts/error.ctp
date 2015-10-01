<!DOCTYPE html>
<html>
    <head>

        <title><?php echo PROJECT_ALIAS . ' | Error'; ?></title>

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <?php
        // Requisição dos css da aplicação
        echo $this->Html->css(array(
            // Requisição dos componentes do framework front-end.
            '../semantic-ui/css/semantic.min',
            '../semantic-ui/css/basic',
            // Requisição dos estilos básicos da aplicação.
            'font/open-sans/css',
            'app/style',
                ), 'stylesheet', array('media' => 'all')
        );

        // Requisição dos scripts que anteriores a renderização.
        echo $this->Html->script(array(
            // Aglomerado de classes primitivas ou baixadas.
            'agglomerate/before_render',
        ));
        ?>
    </head>

    <body>
        <?php echo $this->fetch('content'); ?>
    </body>

    <?php
    // Requisição dos scripts que posteriores renderização.,
    //
    // Scripts que são necessários em qualquer área do sistema.
    echo $this->Html->script(array(
        '../semantic-ui/js/semantic.min',
        // Importando configuração das bibliotecas jQuery
        'config',
        // Parametros básicos da aplicação
        'app/after_render/initialize'
    ));
    ?>
</html>