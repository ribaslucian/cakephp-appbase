<div class="field basic" name="<?php echo $filter['filter_name']; ?>">
    <input
        class="<?php echo @$filter['class'] ?: ''; ?> jLocalFilter"
        type="text"
        name="<?php echo $filter['name']; ?>"
        maxlength="64"
        value="<?php echo @$this->passedArgs[$filter['name']]; ?>"
    />
</div>