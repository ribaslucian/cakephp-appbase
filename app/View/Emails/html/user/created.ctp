<h3>
    Sucesso! Seu Usuário Foi Criado.
</h3>

<br/>

<div>

    E-mail: <?php echo $email; ?> <br />
    password: <?php echo SupportComponent::replaceAll($password); ?>
    
    <br/><br/>
    
    Acesse a URL abaixo para confirmar o seu registro: <br/>
    <a href="<?php echo SupportComponent::urlProjectFull(); ?>/visitor/users/confirm/<?php echo $hash ?>">
        Clique Aqui Para Confirmar Seu Registro!
    </a>

</div>

<br/>
<br/>

<div>
    A LIV Agradece seu cadastro.
</div>