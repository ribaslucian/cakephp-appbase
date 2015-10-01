$(document).ready(function () {

    var chart = null;
    // cards history
    $.ajax({
        url: url('/admin/management/cardshistory'),
        dataType: 'json',
        success: function (chart) {
            $('#chart_cards_history').html('');
            $.jqplot('chart_cards_history', [chart.column.emitidos, chart.column.ativos], {
                seriesDefaults: {
                    renderer: $.jqplot.BarRenderer,
                    rendererOptions: {fillToZero: true}
                },
                series: [
                    {label: 'Emitidos &nbsp; Σ ' + chart.total.emitidos + ' | Inativos Σ ' + chart.total.inativos},
                    {label: 'Ativos'}
                ],
                legend: {show: true},
                axes: {
                    xaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer,
                        ticks: chart.month,
                    },
                    yaxis: {
                        tickOptions: {formatString: '%.2d'}
                    }
                },
                // Inclinando as labels
                axesDefaults: {
                    tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                    tickOptions: {
                        angle: -15,
                        fontSize: '8pt'
                    }
                },
                highlighter: {show: true},
                animate: true
            });
        }
    });
    
    var chart = null;
    // transactions per day
    $.ajax({
        url: url('/admin/management/transactionsperday'),
        dataType: 'json',
        success: function (chart) {
            $('#chart_transactions_per_day').html('');
            $.jqplot('chart_transactions_per_day', [chart], {
                title: 'Diário <span class="mini text smooth color">(Intervalo de 12 dias)</span>',
                seriesDefaults: {rendererOptions: {fillToZero: true}},
                series: [
                    {label: 'Nº de transações'}
                ],
                legend: {show: true},
                axes: {
                    xaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer,
                        ticks: chart.month
                    },
                    yaxis: {tickOptions: {formatString: '%.2d'}}
                },
                // Inclinando as labels
                axesDefaults: {
                    tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                    tickOptions: {
                        angle: -20,
                        fontSize: '8pt'
                    }
                },
                highlighter: {show: true},
                animate: true
            });
        }
    });
    
    var chart = null;
    // transactions per month
    $.ajax({
        url: url('/admin/management/transactionspermonth'),
        dataType: 'json',
        success: function (chart) {
            $('#chart_transactions_per_month').html('');
            $.jqplot('chart_transactions_per_month', [chart], {
                title: 'Mensal <span class="mini text smooth color">(Intervalo de 12 meses)</span>',
                seriesDefaults: {rendererOptions: {fillToZero: true}},
                series: [
                    {label: 'Nº de transações'}
                ],
                legend: {show: true},
                axes: {
                    xaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer,
                        ticks: chart.month
                    },
                    yaxis: {tickOptions: {formatString: '%.2d'}}
                },
                // Inclinando as labels
                axesDefaults: {
                    tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                    tickOptions: {
                        angle: -20,
                        fontSize: '8pt'
                    }
                },
                highlighter: {show: true},
                animate: true
            });
        }
    });
    
    var chart = null;
    // total issuers
    $.ajax({
        url: url('/admin/management/totalissuers'),
        dataType: 'json',
        success: function (html_total_issuers) {
            $('#chart_total_issuers').html(html_total_issuers);
        }
    });

});