<?php echo $this->SemanticForm->create('User', array('class' => 'ui form')) ?>

<br/>

<div class="ui three column grid doubling no margin">

    <div class="column eight wide centered">
        <div class="ui header ticket color  large upper center aligned" style="border-bottom: 1px solid #e6e6e6; margin-bottom: 10px; padding-bottom: 5px;">
            Centro de Ajuda LIV
        </div>

        <div class="ui segment basic bg white border shadow " style="padding: 20px;">
            <h5 class="ui header b smooth color">
                Solicitação de reenvio de e-mail para Alteração de Senha.

                <br/><br/>

                <div class="sub header l small text">
                    Preencha os campos abaixo pra reenviarmos o e-mail para você:
                </div>
            </h5>

            <div class="field">
                <div class="ui input">
                    <?php echo $this->SemanticForm->input('email', array('placeholder' => 'E-mail', 'autofocus' => 'autofocus')); ?>
                    <i class="circular mail"></i>
                </div>
                <?php echo $this->SemanticForm->help('email'); ?>
            </div>

            <div class="field no margin">
                <button type="submit" class="ui button linkedin no radius pull right bg liv">
                    <i class="sign in"></i>
                    Enviar
                </button>

                <a href="<?php echo $this->Html->url('/visitor') ?>" class="ui button no radius pull right basic jq_show_login">
                    <i class="sign in"></i>
                    Cancelar
                </a>
            </div>
        </div>
    </div>
</div>

<?php echo $this->SemanticForm->end(); ?>

<br/>
<br/>
