<div class="ui icon buttons basic small product js_id_cart_product no radius" product="{id}" style="display: none;">
    <div class="ui button">
        {name}
        <i class="b3 large text js_id_cart_product_counter">0</i>
    </div>

    <div class="ui button icon js_id_cart_product_adder" onclick="cart.product_unit_add({id}, 1)">
        <i class="icon add"></i>
    </div>

    <div class="ui button icon js_id_cart_product_withdrawing" onclick="cart.product_unit_add({id}, -1)">
        <i class="icon minus"></i>
    </div>
</div>