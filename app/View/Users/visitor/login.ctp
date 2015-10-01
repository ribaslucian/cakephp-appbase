<?php echo $this->SemanticForm->create('User', array('class' => 'ui form')); ?>

<div class="ui two column grid page doubling">

    <div class="column four wide"></div>

    <div class="column">

        <div class="ticket color" style="padding: 0 3%;">
            <div class="ui header huge no margin">
                <span class="sans b3">CakePHP [base]</span>
            </div>

            <div class="ui header l small no margin ticket color">
                Base application for CakePHP system.
            </div>
        </div>

        <div class="ui segment basic bg white border shadow" style="padding: 20px;">

            <div class="field">
                <div class="icon input">
                    <?php echo $this->SemanticForm->input('email', array('placeholder' => 'E-mail', 'autofocus' => 'autofocus', 'required' => true)); ?>
                    <i class="circular mail"></i>
                </div>
            </div>

            <div class="field">
                <div class="icon input">
                    <?php echo $this->SemanticForm->input('password', array('placeholder' => 'Senha', 'type' => 'password', 'required' => false)); ?>
                    <i class="circular lock"></i>
                </div>
            </div>

            <div class="field no margin">
                <button type="submit" class="ui fluid button labeled right linkedin no radius  bg liv">
                    <i class="sign in"></i>
                    Entrar
                </button>
            </div>
        </div>

        <a href="<?php echo $this->Html->url('/visitor/users/help') ?>" class="pull right small text ticket color" style="margin-right: 5%;">
            <i class="sign in"></i>
            Precisa de Ajuda ?
        </a>

    </div>
</div>

<?php echo $this->SemanticForm->end(); ?>

<br/>
<br/>

