<div class="ui inline dropdown hover pointing left top relative" style="top: -4px;">
    <i class="icon big blue ellipsis vertical link"></i>
    <div class="menu">
        <a href="#" class="item b">
            <i class="bar chart icon large yellow"></i>
            Opção 01
        </a>

        <a href="#" class="item b">
            <i class="icon history large blue"></i>
            Opção 02
        </a>
    </div>
</div>

&nbsp;&nbsp;
<div class="ui inline dropdown hover pointing left top relative" style="top: -4px;">
    <span class="b2" style="color: white;">
        Opção 03
        <i class="ui icon angle down" ></i>
    </span>

    <div class="menu">
        <a href="<?php echo $this->Html->url('/admin/issuers/index') ?>" class="item b">
            <i class="icon suitcase large teal"></i>
            Opção 04
        </a>

        <a href="<?php echo $this->Html->url('/admin/holders/index') ?>" class="item b">
            <i class="icon users large brown color"></i>
            Opção 05
        </a>

        <a href="<?php echo $this->Html->url('/admin/sellers/index') ?>" class="item b">
            <i class="icon building large color green"></i>
            Opção 06
        </a>
    </div>
</div>

<div class="pull right relative" style="top: -4px;">

    <div class="ui inline dropdown hover right top pointing">
        <?php if (file_exists(WWW_ROOT . '/img/users/' . $this->getUserName() . '.jpg')) { ?>
            <?php
            echo $this->Html->image('users/' . $this->getUserName() . '.jpg', array(
                'class' => 'ui tiny circular image inline bordered',
                'style' => 'width: 38px; border-color: #222;'
            ));
            ?>
        <?php } else { ?>
            <i class="icon big green user"></i>
        <?php } ?>

        <div class="menu">
            <a href="<?php echo $this->Html->url('/admin/users/user_edit') ?>" class="item b">
                <i class="icon large user"></i>
                Editar Perfil
            </a>

            <a href="<?php echo $this->Html->url('/admin/users/logout') ?>" class="item b">
                <i class="icon log out large"></i>
                Sair
            </a>
        </div>
    </div>
</div>