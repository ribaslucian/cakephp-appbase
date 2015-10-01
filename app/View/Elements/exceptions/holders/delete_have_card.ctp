<div class="ui warning message no radius shadow" style="margin: 12px;">
    <i class="icon close"></i>
    <i class="icon large basic attention"></i>
    <span class="mini text">
        Para excluir este titular é necessário deletar seus cartões.
        <a class="b pointer underline" href="<?php echo $this->Html->url('/admin/holders/cards/'. $holder['Holder']['id']); ?>">
            Visualizar cartões de <?php echo $holder['Holder']['name']; ?>
            <i class="icon link external square"></i>
        </a>
    </span>
</div>
