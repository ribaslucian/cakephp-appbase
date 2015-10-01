<div class="field date" name="<?php echo $filter['filter_name']; ?>">
    <input
        class="date mask jLocalFilter"
        type="text"
        name="<?php echo $filter['start_name']; ?>"
        value="<?php echo @$this->passedArgs[$filter['start_name']]; ?>"
    />
</div>

<div class="field date" name="<?php echo $filter['filter_name']; ?>">
    <input
        class="date mask jLocalFilter"
        type="text"
        name="<?php echo $filter['end_name']; ?>"
        value="<?php echo @$this->passedArgs[$filter['end_name']]; ?>"
    />
</div>
