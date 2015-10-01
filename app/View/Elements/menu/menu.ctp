<?php if ($this->hierarchy != 'visitor') { ?>
    <div class="menu principal">
        <div style="margin: 10px !important;">
            <a href="<?php echo $this->Html->url('/' . $this->hierarchy) ?>" class="ui header white color large b3 inline" style="margin-right: 10px;">
                LIV
            </a>

            <?php echo $this->element('menu/options/' . $this->hierarchy) ?>
        </div>
    </div>
<?php } ?>