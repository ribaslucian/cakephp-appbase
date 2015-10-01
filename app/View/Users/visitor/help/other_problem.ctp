<?php echo $this->SemanticForm->create('Email', array('class' => 'ui form')) ?>

<br/>

<div class="ui three column grid doubling no margin">

    <div class="column eight wide centered">
        <div class="ui header ticket color  large upper center aligned" style="border-bottom: 1px solid #e6e6e6; margin-bottom: 10px; padding-bottom: 5px;">
            Centro de Ajuda LIV
        </div>

        <div class="ui segment basic bg white border shadow " style="padding: 20px;">
            <h5 class="ui header b smooth color">
                OUTRO PROBLEMA

                <br/><br/>

                <div class="sub header l small text">
                    Por favor, preencha os campos abaixo:
                </div>
            </h5>

            <div class="field">
                <label for="EmailName">
                    <i class="icon asterisk purple"></i>
                    Seu nome:
                </label>

                <div class="input">
                    <?php echo $this->SemanticForm->input('name', array('maxlength' => 92)); ?>
                </div>

                <?php echo $this->SemanticForm->help('name'); ?>
            </div>

            <div class="field">
                <label for="EmailEmail">
                    <i class="icon asterisk purple"></i>
                    E-mail:
                </label>

                <div class="input">
                    <?php echo $this->SemanticForm->input('email', array('maxlength' => 92)); ?>
                </div>

                <?php echo $this->SemanticForm->help('email'); ?>
            </div>

            <div class="field">
                <label for="EmailDescription">
                    <i class="icon asterisk purple"></i>
                    Descrição:
                    <div class="small text smooth color">
                        <ul>
                            <li>Descreva seu problema;</li>
                            <li>Seja objetivo;</li>
                        </ul>
                    </div>
                </label>

                <div class="input">
                    <?php echo $this->SemanticForm->textarea('description', array('maxlength' => 512)); ?>
                </div>

                <?php echo $this->SemanticForm->help('description'); ?>
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
