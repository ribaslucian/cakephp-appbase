var LocalFilter = function () {

    /**
     * Elementos de filtragem relacionados entre si.
     * Exemplo (input: elements):
     * - Entrada do filtro (input);
     * - Onde este filtro irá afetar (linhas da tabela).
     * 
     * @type array, object
     */
    this.local_filters = config.filter_local;

    /**
     * Última entrada válida no elemento de filtragem (input).
     * 
     * @type string
     */
    this.last_value = null;

    /**
     * Evento de inserção/remoção de caracteres do elemento de filtragem (input).
     */
    $.each(this.local_filters, function (input, entities) {
        $(input).keyup(function () {
            // Atribuindo valor de entrada em uma 
            // variável para uma melhor legebilidade do código.
            var value = $(this).val();

            // Efetuar o filtro apenas se a entrada for alterada.
            if (value != local_filter.last_value) {
                // Efetuar o filtro apenas se a entrada não estiver vazia. Caso 
                // contrário deve-se apresentar as entidades que foram escondidas.
                if (!isEmpty(value)) {
                    local_filter.last_value = value;

                    // Destacar área que possuem o valor da entrada.
                    // $(entities + ":contains('" + value + "')").css('border', '1px solid #e1e1e1');

                    // Para um melhor visualização, escondemos as 
                    // entradar que não possuem o valor da entrada, 
                    // e apresentador as que possuem
                    $(entities).not(":contains('" + value + "')").hide();
                    $(entities + ":contains('" + value + "')").show();
                } else {
                    // Apresentar entidades escondidas.
                    $(entities).show();

                    local_filter.last_value = null;
                }
            }

        });
    });

};

var local_filter = new LocalFilter();