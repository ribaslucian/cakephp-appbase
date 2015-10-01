<br/>

<style>
    .accordion .title {
        padding: 25px 30px !important;
    }
</style>

<div class="ui grid three column wide doubling">

    <div class="column eight wide centered">

        <div class="ui header ticket color large upper center aligned" style="border-bottom: 1px solid #e6e6e6; margin-bottom: 10px; padding-bottom: 5px;">
            Centro de Ajuda LIV
        </div>

        <div class="ui styled fluid accordion shadow no radius">

            <div class="active title b">
                <i class="dropdown icon"></i>
                Esqueceu sua senha ?
            </div>

            <div class="active content">
                <p>
                    - Você pode solicitar uma alteração de senha 
                    <a class="ticket color large text" href="<?php echo $this->Html->url('/visitor/users/password_forgot') ?>">clicando aqui</a>.
                </p>

                <p class="small text">
                    - Lembramos você que será possível apenas se seu registro estiver confirmado.
                </p>
            </div>

            <div class="title b">
                <i class="dropdown icon"></i>

                Não recebeu o e-mail para Confirmar seu Registro ?
            </div>

            <div class="content">
                <p class="small text">
                    <i class="icon basic attention circle large"></i>
                    Verifique sua lixeira e caixa de span, nosso e-mail pode estar lá.
                </p>
                <p>
                    - Você pode solicitar um reenvio de e-mail 
                    <a class="ticket color large text" href="<?php echo $this->Html->url('/visitor/users/resend_email_confirmation') ?>">clicando aqui</a>.
                </p>
                <p class="small text">
                    - Lembramos você que está ação será possível somente se seu usuário ainda não estiver confirmado.
                </p>
            </div>

            <div class="title b">
                <i class="dropdown icon"></i>
                Não recebeu o e-mail para Alterar de Senha ?
            </div>

            <div class="content">
                <p class="small text">
                    <i class="icon basic attention circle large"></i>
                    Verifique sua lixeira e caixa de span, nosso e-mail pode estar lá.
                </p>
                <p>
                    - Você pode efetuar a solicitação novamente
                    <a class="ticket color large text" href="<?php echo $this->Html->url('/visitor/users/password_forgot') ?>">
                        clicando aqui
                    </a>.
                </p>
            </div>

            <div class="title b">
                <i class="dropdown icon"></i>
                Estou com outro Problema
            </div>

            <div class="content">
                <a href="<?php echo $this->Html->url('/visitor/users/other_problem'); ?>" class="ticket color">
                    Clique Aqui para Descrever Seu Problema
                </a>
            </div>
        </div>
    </div>

</div>