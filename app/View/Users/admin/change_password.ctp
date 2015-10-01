<br/>

<?php echo $this->SemanticForm->create('User', array('class' => 'ui form')) ?>

<?php echo $this->SemanticForm->hidden('id'); ?>
<?php echo $this->SemanticForm->hidden('email'); ?>

<div class="ui three column grid doubling no margin">

    <div class="column eight wide centered">
        <br/>

        <div class="ui segment basic bg white border shadow " style="padding: 20px;">
            <h5 class="ui header b smooth color">
                <span class="large text b3">
                    <?php echo $this->request->data['User']['email'] ?>
                </span>

                <br/><br/>

                <div class="sub header l small text">
                    Preencha os campos abaixo para alterar sua senha:
                </div>
            </h5>

            <div class="field">
                <div class="input">
                    <?php echo $this->SemanticForm->password('password', array('placeholder' => 'Senha', 'autofocus' => 'autofocus')); ?>
                    <i class="circular mail"></i>
                </div>

                <?php echo $this->SemanticForm->help('password'); ?>
            </div>

            <div class="field">
                <div class="input">
                    <?php echo $this->SemanticForm->password('password_confirm', array('placeholder' => 'Digite sua senha novamente', 'autofocus' => 'autofocus')); ?>
                    <i class="circular mail"></i>
                </div>

                <?php echo $this->SemanticForm->help('password_confirm'); ?>
            </div>

            <div class="field no margin">
                <button type="submit" class="ui button linkedin no radius pull right bg liv">
                    <i class="sign in"></i>
                    Enviar
                </button>

                <a href="<?php echo $this->Html->url('/admin') ?>" class="ui button no radius pull right basic jq_show_login">
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
