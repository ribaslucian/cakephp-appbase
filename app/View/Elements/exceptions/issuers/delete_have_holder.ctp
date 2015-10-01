<div class="ui warning message no radius shadow" style="margin: 12px;">
    <i class="icon close"></i>
    <i class="icon large basic attention"></i>
    <span class="mini text"> 
        Para excluir este contratante é necessário deletar seus titulares. 
        <a class="b pointer underline" href="<?php echo $this->Html->url('/admin/issuers/holders/'. $issuer['Issuer']['id']); ?>">
            Listar titulares de 
            <span class="upper b2">
                <?php echo $issuer['Issuer']['fantasy_name']; ?>
            </span>
            
            <i class="icon link external square"></i>
        </a>
    </span>
</div>
