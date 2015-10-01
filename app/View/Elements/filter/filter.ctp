<div class="ui form filter small" url="<?php echo $this->urlClear; ?>" args='<?php echo json_encode($this->args); ?>'>
    <div class="inline fields">
        <div class="field">
            <label>
                <div class="ui dropdown bottom pointing options">

                    <i class="icon link search large"></i>
                    <div class="text active"><?php echo $filter['options'][0]; ?></div>

                    <i class="dropdown icon"></i>

                    <div class="menu">
                        <?php foreach ($filter['options'] as $option) { ?>
                            <div class="option item"><?php echo $option; ?></div>
                        <?php } ?>
                    </div>
                </div>
            </label>
        </div>

        <?php foreach ($filter['inputs'] as $input) { ?>
            <?php echo $this->element("filter/type/{$input['type']}", array('filter' => $input['options'])); ?>
        <?php } ?>

        <?php echo $this->element('filter/partial/instruction'); ?>
    </div>
</div>

<script>
    $('.jq_id_filter_clear').click(function() {
        $('.filter').fadeOut('fast');
        $('input', $('.filter')).val('');
        $('.filter').fadeIn('fast');

        var e = jQuery.Event("keyup");
        e.which = 13; // # Some key code value
        e.keyCode = 13; // # Some key code value
        $(".filter input:first").trigger(e);
    });
</script>