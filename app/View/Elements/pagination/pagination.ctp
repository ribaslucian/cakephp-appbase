<?php if ($this->Paginator->param('pageCount') > 1) { ?>

    <?php
    if (empty($get)):
        $get = '';
    endif;

    $urlReplace = array_key_exists('page', $this->passedArgs) ? 'page:' . $this->passedArgs['page'] : null;
    $url = empty($urlReplace) ? SupportComponent::url() . '/{page}' . $get : str_replace($urlReplace, '{page}' . $get, SupportComponent::url());
    $url .= '?' . http_build_query($_GET);
    $prev = ($this->Paginator->param('page') - 1 > 0) ? str_replace('{page}', 'page:' . ($this->Paginator->param('page') - 1), $url) : null;
    $next = ($this->Paginator->param('page') + 1 <= $this->Paginator->param('pageCount')) ? str_replace('{page}', 'page:' . ($this->Paginator->param('page') + 1), $url) : null;
    ?>

    <h5 class="small text smooth color" style="display: inline; margin-right: 4px;">
        <?php echo $this->Paginator->counter('<span class="small text"> <span class="b3">Pg.</span> {:page}/{:pages} &nbsp; <span class="b3">Rgs.</span> {:start}-{:end}/{:count} </span>'); ?>
    </h5>

    <a <?php echo $prev ? 'href="' . $prev . '"' : ''; ?> class="ui button icon no radius no margin mini <?php echo $prev ? '' : 'disabled'; ?>" title="Retornar para página <?php echo $this->Paginator->param("page") - 1; ?>.">
        <i class="icon arrow left link"></i>
    </a>

    <span class="ui form relative">
        <div class="ui input mini jPaginatorSubmit" style="width: 52px;">
            <input type="text" class="no radius text center mask natural number" placeholder="Nª" style="padding: 6px; font-size: 10px; font-weight: 600 !important; position: relative; top: -1px" autofocus="1">
        </div>
    </span>

    <a <?php echo $next ? 'href="' . $next . '"' : ''; ?> class="ui button icon no radius no margin mini <?php echo $next ? '' : 'disabled'; ?>" title="Ir para página <?php echo $this->Paginator->param("page") + 1; ?>.">
        <i class="icon arrow right link"></i>
    </a>

    <div class="hidden pagination">
        <div class="current"><?php echo $this->Paginator->param('page'); ?></div>
        <div class="url"><?php echo $url; ?></div>
        <div class="count"><?php echo $this->Paginator->param('pageCount'); ?></div>
    </div>

<?php } else { ?>
    <small class="smooth color">
        Página única.
    </small>
<?php } ?>
