<div class="ui form filter small no margin no padding" url="<?php echo $this->urlClear; ?>" args='<?php echo json_encode($this->args); ?>'>
    <div class="inline fields">
        <div class="field">
            <label>
                <div class="ui dropdown bottom pointing options">

                    <i class="icon link search"></i>
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
            <?php echo $this->element("lib/filter/type/{$input['type']}", array('filter' => $input['options'])); ?> 
        <?php } ?> 

        <?php echo $this->element('lib/filter/partial/instruction'); ?>
    </div>
</div>
