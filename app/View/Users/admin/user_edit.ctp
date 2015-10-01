<div class="page content shadow bg white">

    <div class="ui header no margin title">
        <div class="centered upper b3">
            <i class="icon user large"></i>
            <?php echo $this->request->data['User']['name'] ?>
        </div>
    </div>

    <br/>
    <br/>

    <?php echo $this->SemanticForm->create('User', array('class' => 'ui form')); ?>

    <?php
    if (!empty($this->request->data['User']['id'])) {
        echo $this->SemanticForm->hidden('id', array(
            'value' => $this->request->data['User']['id']
        ));
    }
    ?>

    <div class="ui three column grid">
        <div class="row">

            <div class="column" style="padding-left: 40px;"></div>

            <div class="column">
                <div class="shadow">
                    <div class="ui attached segment">
                        <br/>
                        <h4 class="ui dividing header b3 no margin">Dados de Usuário</h4>
                        <div class="two fields">
                            <div class="field">
                                <label class="small text smooth color">
                                    Data de Nascimento:
                                </label>

                                <div class="input">
                                    <?php
                                    echo $this->SemanticForm->text('birthday', array(
                                        'class' => 'date mask',
                                        'value' => @$this->request->data['User']['birthday']
                                    ));
                                    ?>
                                </div>

                                <?php echo $this->SemanticForm->help('birthday'); ?>
                            </div>
                        </div>
                        <br/>
                        <h4 class="ui dividing header b3 no margin">Dados de acesso</h4>

                        <div class="field">
                            <label class="small text smooth color">
                                Senha:
                            </label>

                            <div class="input">
                                <?php
                                echo $this->SemanticForm->password('password', array());
                                ?>
                            </div>

                            <?php echo $this->SemanticForm->help('password'); ?>
                        </div>
                        <div class="field">
                            <label class="small text smooth color">
                                Confirme sua senha:
                            </label>

                            <div class="input">
                                <?php
                                echo $this->SemanticForm->password('password_confirm', array());
                                ?>
                            </div>

                            <?php echo $this->SemanticForm->help('password_confirm'); ?>
                        </div>
                    </div>
                </div>

                <br />
            </div>
        </div>
    </div>

    <button type="submit" class="ui button icon bottom right huge no radius linkedin" style="position: fixed; bottom: 7%; right: 4%;">
        <i class="icon check"></i>
    </button>

    <?php echo $this->SemanticForm->end(); ?>


    <br/>
    <br/>
</div>