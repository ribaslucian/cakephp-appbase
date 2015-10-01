<!DOCTYPE html>
<html>
    <head>

        <title>LIV RELATÓRIO</title>

        <!--
        <link href='http://fonts.googleapis.com/css?family=
        Source+Sans+Pro:400,700|Open+Sans:300italic,400,300,700'
        rel='stylesheet' type='text/css'>
        -->

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

        <?php
        echo $this->Html->charset();

        // Requisição dos css da aplicação
        echo $this->Html->css(array(
            // Requisição dos componentes do framework front-end.
            '../semantic/semantic.min',
            // Requisição dos estilos básicos da aplicação.
            'font/open-sans/css',
            'app/style',
                ), 'stylesheet', array('media' => 'all')
        );

        echo $this->Html->script(array(
            'core/jquery',
            'application/functions',
        ));
        ?>

        <style>
            * { margin:0; padding:0; border:none; border-collapse:collapse; }
            html, body {
                margin: 0 !important;
                padding: 0 !important;
                background: white;
            }

            .top { padding-left: 3%; }
            .top .module_name { top: -15px; position: relative; }
            .top .module_name .icon { display: inline !important; font-size: 40px !important; }
            .top .info { font-size: 85% !important; }
            .app_timer { display: none !important; }
            hr { border: 0 !important; height: 1px; background-color: #eee; margin-top: -3px; }

            thead tr { background-color: #f6f6f6 !important; }
        </style>
    </head>

    <body>
        <div class="jq_block_print">
            <?php echo $this->fetch('content'); ?>
        </div>
    </body>

    <?php
    // Scripts que são necessários em qualquer área do sistema.
    echo $this->Html->script(array(
        // Aglomerado de classes primitivas ou baixadas.
        'primitive/agglomerate',
        // Importando configuração das bibliotecas jQuery
        'app/config',
        // Parametros básicos da aplicação
        'app/initialize'
    ));
    ?>

    <script>
        $(document).ready(function () {
            $('.jq_block_print').fadeIn('fast', function () {
               window.print();
               //window.close();
            });
        });
    </script>
</html>