<div class="field date" name="<?php echo $filter['filter_name']; ?>">
    <input 
        type="text"
        autofocus="1"
        class="date mask jLocalFilter"
        name="<?php echo $filter['start']; ?>" 
        value="<?php echo @$this->passedArgs[$filter['start']] ?: ''; ?>" 
    />      
</div>

<div class="field date" name="<?php echo $filter['filter_name']; ?>">
    <input 
        type="text"
        class="date mask jLocalFilter"
        name="<?php echo $filter['end']; ?>"
        value="<?php echo @$this->passedArgs[$filter['end']] ?: ''; ?>"
    />
</div>
