<!DOCTYPE html>
<html>
    <head>

        <title>LIV</title>

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <?php echo $this->element('page/css'); ?>
    </head>

    <body>
        <?php echo $this->element('page/loader'); ?>

        <div class="body relative" style="display: none;">
            <?php
            echo $this->element('menu/menu');
            echo $this->element('flash/flash');
            echo $this->element('page/global');
            echo $this->fetch('content');
//            echo $this->element('page/maintenance');
            ?>

        </div>

        <?php echo $this->element('page/script'); ?>
    </body>

</html>