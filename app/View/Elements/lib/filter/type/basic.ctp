<div class="field basic" name="<?php echo $filter['filter_name']; ?>">
    <input 
        type="text"
        autofocus="1"
        name="<?php echo $filter['name']; ?>"
        class="<?php echo @$filter['class'] ?: ''; ?> jLocalFilter"
        value="<?php echo @$this->passedArgs[$filter['name']] ?: ''; ?>"
    />
</div>