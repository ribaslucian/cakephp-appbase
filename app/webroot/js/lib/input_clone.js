function InputClone() {
    
    /**
     * Identificador do INPUT de origem (valor a ser copiado).
     */
    this.origin = '.jq_ic_origin';
    
    /**
     * Identificador do(s) elemento(s) de destino, 
     * conterão o valor do INPUT origem.
     */
    this.destiny = '.jq_ic_destiny';
    
    /**
     * Evento que representa a alteração do valor do Input Origem.
     */
    $(this.origin).keyup(function() {
        $(ci.destiny).val($(this).val());
    });
    
}

var ci = new InputClone();