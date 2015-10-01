function TableSelectRows() {
    
    /**
     * Identificador do elemento que representará uma 
     * linha da tabela Selecionada (ticada), ao clicar 
     * neste elemento a mesma será descelecionada.
     */
    this.selected = '.jq_tsr_selected';
    
    /**
     * Identificador do elemento que representará uma 
     * linha da tabela Descelecionada (não ticada), ao clicar 
     * neste elemento a mesma será Selecionada.
     */
    this.unselected = '.jq_tsr_unselected';
    
    /**
     * Identificador do elemento que representará a Seleção de todas as linhas
     * da tabela. Ao clicar neste elemento todas as linhas serão Descelecionadas.
     */
    this.selected_all = '.jq_tsr_selected_all';
    
    /**
     * Identificador do elemento que representará a Não-Seleção de todas as linhas
     * da tabela. Ao clicar neste elemento todas as linhas serão Selecionadas.
     */
    this.unselected_all = '.jq_tsr_unselected_all';
    
    /**
     * Estilo CSS que se atribuirá na TAG da linha da tabela que for selecionda.
     */
    this.tr_selected_css = 'background-color: #ffffcc; border-bottom: 1px solid #f7f8c2;';
    
    /**
     * Estilo CSS que se atribuirá na TAG da linha da tabela que for Desselecionda.
     */
    this.tr_unselected_css = 'background-color: none;';
    
    
    /**
     * Evento que representa o clique em um elemento 
     * Selecionado, isso acarretará em uma Desceleção.
     */
    $(this.selected).click(function() {
        var tr = $(this).parents('tr');
        
        tr.attr('style', tsr.tr_unselected_css);
        $(this).hide();
        $(tsr.unselected, tr).show('fast');
        
        // como este evento acarretará em um desceleção, significa que nem todos
        // os elementos da tabela estão selecionados, caso o elemento que 
        // representa a seleção de todos os elementos da tabela esteja ticado, 
        // devemos 'desticado';
        $(tsr.selected_all).hide();
        $(tsr.unselected_all).show('fast');
    });
    
    /**
     * Evento que representa o clique em um elemento 
     * Deselecionado, isso acarretará em uma seleção.
     */
    $(this.unselected).click(function() {
        var tr = $(this).parents('tr');
        
        tr.attr('style', tsr.tr_selected_css);
        $(this).hide();
        $(tsr.selected, tr).show('fast');
    });
    
    /**
     * Evento que representa o clique no elemento que representa a seleção de
     * todos os registro na tabela, isso acarretará em uma desceleção global.
     */
    $(this.selected_all).click(function() {
        $(this).hide();
        $(tsr.unselected_all).show('fast');
        
        var table = $(this).parents('table');
        var trs = $('tbody tr', table);
        var selectors = $(tsr.selected + ',' + tsr.unselected, table);
        var selects = $(tsr.unselected, table);
        
        trs.attr('style', tsr.tr_unselected_css);
        selectors.hide();
        selects.show('fast');
    });
    
    /**
     * Evento que representa o clique no elemento que representa a Desceleção de
     * todos os registro da tabela, isso acarretará em uma Seleção global.
     */
    $(this.unselected_all).click(function() {
        $(this).hide();
        $(tsr.selected_all).show('fast');
        
        var table = $(this).parents('table');
        var trs = $('tbody tr', table);
        var selectors = $(tsr.selected + ',' + tsr.unselected, table);
        var unselects = $(tsr.selected, table);
        
        trs.attr('style', tsr.tr_selected_css);
        selectors.hide();
        unselects.show('fast');
    });

}

var tsr = new TableSelectRows();