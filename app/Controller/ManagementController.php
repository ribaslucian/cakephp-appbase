<?php

class ManagementController extends AppController {

    public function admin_index() {
        $this->average_transaction_ticket();
    }

    /**
     * 
     * @return <array> with chats datas
     */
    public function admin_cards_history() {
        $this->loadModel('Card');

        # obtendo sql que captura os dado para o gráfico
        $sql = file_get_contents(APP . 'Outside' . DS . 'Scripts' . DS . 'management_painel' . DS . 'cards_history.sql');

        # unindo valoes mensais em um unico índice
        $full_history = $dates = array();
        foreach ($this->Card->query($sql) as $history) {
            if ($history[0]['month'] == 'total') {
                $full_history['total'][$history[0]['description']] = $history[0]['amount'];
                continue;
            }

            # Retirando espaços gerados pelo banco no mês.
            $month = str_replace(' ', '', $history[0]['month']);

            # Ensirindo data no historico
            $full_history['month'][] = $month;

            # Inserindo Valor na coluna respectiva emitidos/ativos/inativos
            $full_history['column'][$history[0]['description']][] = $history[0]['amount'];
        }

        # retirando datas repetidas
        $full_history['month'] = array_values(array_unique($full_history['month']));

        $this->returnJs($full_history);
    }

    /**
     * 
     * @return <array> with chats datas
     */
    public function admin_transactions_per_day() {
        $this->loadModel('Transaction');

        # obtendo sql que captura os dado para o gráfico
        $sql = file_get_contents(APP . 'Outside' . DS . 'Scripts' . DS . 'management_painel' . DS . 'transactions_per_day.sql');

        $transactions_per_day = array();
        foreach ($this->Transaction->query($sql) as $day) {

            $transactions_per_day[] = array(
                str_replace(' ', '', $day[0]['day']),
                intval($day[0]['amount']),
            );
        }

        $this->returnJs($transactions_per_day);
    }

    /**
     * 
     * @return <array> with chats datas
     */
    public function admin_transactions_per_month() {
        $this->loadModel('Transaction');

        # obtendo sql que captura os dado para o gráfico
        $sql = file_get_contents(APP . 'Outside' . DS . 'Scripts' . DS . 'management_painel' . DS . 'transactions_per_month.sql');

        $transactions_per_month = array();
        foreach ($this->Transaction->query($sql) as $day) {

            $transactions_per_month[] = array(
                $day[0]['month'],
                $day[0]['amount'],
            );
        }

        $this->returnJs($transactions_per_month);
    }

    /**
     * 
     * @return <array> with chats datas
     */
    public function admin_total_issuers() {
        $this->loadModel('Transaction');
        
        # obtendo sql que captura os dado para o gráfico
        $sql = file_get_contents(APP . 'Outside' . DS . 'Scripts' . DS . 'management_painel' . DS . 'total_issuers.sql');
        
        $view = new View();
        $this->returnJs(
            $view->element('../Management/admin/partial/total_issuers_table', array(
                'total_issuers' => $this->Transaction->query($sql)
            ))
        );
    }
    
    
    public function average_transaction_ticket() {
        $this->loadModel('Transaction');
        
        $transaction = $this->Transaction->query('SELECT AVG(value) FROM transactions;');
        $transaction = $transaction[0][0]['avg'];
        
        $card = $this->Transaction->query('SELECT AVG(balance) FROM cards;');
        $card = $card[0][0]['avg'];
        
        $this->set('avg', array(
            'Transação' => $transaction,
            'Cartão (saldo)' => $card,
        ));
    }

}
