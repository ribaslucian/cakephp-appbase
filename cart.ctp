<style>
    /** cart */
    .__cart_container {
        bottom: 0px;
        width: 100%;
        position: fixed !important;
        border-top: 1px solid #fff;
        background: #fff9ff !important;
    }
    
    .__cart_counter {
        margin-top: 3px;
    }
    
    .cart.label {
        position: relative;
        bottom: -3px;
    }
</style>

<div class="ui message __cart_form __cart_container no margin">
    <div class="centered">
        <span class="ui label green small text __cart_counter no radius">0</span>
        <i class="icon big cart green"></i>

        <span class="b text large cart label">
            CARRINHO
        </span>

        <div style="border: 1px solid #ccc; display: inline; margin: 0 15px 0 8px; position: relative; bottom: -2px;"></div>

        <div class="products inline">   
            <div class="ui icon buttons basic small">
                <div class="ui button">
                    Celular
                    <i class="b3 large text" style="background-color: #eee; padding: 2px 6px;">1</i>
                </div>
                
                <div class="ui button"><i class="icon add"></i></div>
                <div class="ui button"><i class="icon minus"></i></div>
            </div>
        </div>
    </div>

</div>