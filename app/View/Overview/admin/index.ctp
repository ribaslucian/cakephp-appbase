<br/>
<br/>

<div class="page content bg">
    <div class="ui three column grid page">
        <div class="row">
            <div class="column">
                <div class="smooth color">
                    Aniversariantes do Mês
                </div>

                <table class="ui table very basic unstackable" style="width: 70%;">
                    <tbody>
                        <?php foreach ($birthdays as $birthday) { ?>
                            <tr>
                                <td>
                                    <div class="relative large text upper b3" style="top: -2px;">
                                        <?php echo $birthday['User']['email']; ?>
                                    </div>
                                </td>

                                <td class="mini text smooth color">
                                    <?php echo $birthday['User']['birthday']; ?>
                                    <i class="icon calendar red large relative" style="top: -2px"></i>
                                </td>
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="column">
                <div class="ui header center aligned huge smooth color" style="margin-top: 4%;">
                    <style>
                        .jq_profile_photo { opacity: 1; } 
                        .jq_profile_photo:hover { opacity: 0.8; }

                        .jq_send_photo { opacity: 0.3; } 
                        .jq_send_photo:hover { opacity: 0.6; }
                    </style>
                    <?php if (file_exists(WWW_ROOT . '/img/users/' . $this->getUserName() . '.jpg')) { ?>
                        <a class="jq_profile_photo ui small circular image centered shadow bordered" href="<?php echo $this->Html->url('/admin/users/send_photo'); ?>" title="Alterar foto de perfil.">
                            <?php echo $this->Html->image('users/' . $this->getUserName() . '.jpg'); ?>
                        </a>
                    <?php } else { ?>
                        <a class="jq_send_photo ui small circular image centered shadow bordered" href="<?php echo $this->Html->url('/admin/users/send_photo'); ?>" title="Enviar foto de perfil.">
                            <?php echo $this->Html->image('users/user.png'); ?>
                        </a>
                    <?php } ?>

                    <br/> 

                    <span class="b3 upper text large">
                        <?php echo $this->getUserName(); ?>
                    </span>

                    <div class="l text tiny">
                        <div class="l text small">
                            &lt;<?php echo $user->email; ?>&gt;
                        </div>
                    </div>

                    <br/>

                    <div class="centered">
                        <i class="icon child" title="Eu feliz."></i>

                        <div class="l tiny text relative" style="top: -5px;">
                            <span class="l tiny text">
                                <span class="l tiny text">
                                    Tenha um bom trabalho!
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
