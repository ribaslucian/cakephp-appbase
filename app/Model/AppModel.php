<?php

/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

    /**
     * Efetuar ou não log das ações
     *
     * @var boolean
     */
    public $log = true;

    /**
     * Iniciando variavel que conterá os dados do log de ações em cada modelo.
     *
     * @var array
     */
    protected $logListernetData = array(
        'event' => null,
        'user_id' => null,
        'data' => array(),
    );

    /**
     * Sobreescrita do construtor para que no momento da instanciação qualquer
     * modelo comece com sua recusividade definida como -1, isto evita a busca
     * de registro pertencentes a relação sem a definição manual.
     */
    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->recursive = -1;
    }

    /**
     * Efetua a contagem de registros pertencentes a um determinado modelo.
     *
     * @param type $conditions condições para a contagem
     * @return int
     */
    public function count($conditions = null) {
        $count = $this->find('all', array(
            'fields' => 'count(*)',
            'conditions' => $conditions,
        ));

        return $count[0][0]['count'];
    }

    /**
     * Validações efetuados pela classe Vendor/Validation
     *
     * @param type $value
     * @param type $type
     * @return boolean valid
     */
    public function custom($value, $type) {
        App::uses('CustomValidate', 'Vendor');
        $key = array_keys($value);
        return CustomValidate::$type($value[$key[0]]);
    }

    /**
     * Validação para a confirmação de senha, basta você setar ele para o campo password
     * e no formulario de envio adicionar um campo a mais chamado password_confirmed
     */
    public function confirmPassword($value) {
        return $this->data[$this->name]['password'] !== $this->data[$this->name]['password_confirm'] ? false : true;
    }

    /**
     * Validação que obriga o usuário a inserir uma
     * quantidade minima de Letras em um determinado campo.
     *
     * @param int $min Mínimo de Letras.
     * @return bool possui ou não possui a quantidade mínimna.
     */
    public function minLetter($value, $min = 2) {
        $key = array_keys($value);
        $value = $value[$key[0]];

        return strlen(preg_replace('/[0-9]/', '', $value)) >= $min;
    }

    /**
     * Validação que obriga o usuário a inserir uma
     * quantidade minima de Números em um determinado campo.
     *
     * @param int $min Mínimo de Números.
     * @return bool possui ou não possui a quantidade mínimna.
     */
    public function minNumber($value, $min = 2) {
        $key = array_keys($value);
        $value = $value[$key[0]];

        return strlen(preg_replace('/[A-Za-z]/', '', $value)) >= $min;
    }

    /**
     * Captura o evento que irá ocorrer no banco de dados.
     *
     * @return string nome do evento
     */
    public function getEvent() {
        $event = 'insert';

        if (array_key_exists('id', $this->data[$this->name])) {
            $event = 'update';

            if (count($this->data[$this->name]) == 1)
                $event = 'delete';
        }

        return $event;
    }

    /**
     * Efetuar log dos dados antes de serem deletados.
     * @Override
     */
    public function afterDelete() {
        if (!$this->log)
            return;

        $this->logListernetData['event'] = 'delete';
        $this->logListernetData['data']['id'] = $this->id;
        $this->listenerLog('delete');
    }

    /**
     * Defido a alteracoes que podem correr no model,
     * preparar dados que irão compor o log antes de salvo-lo.
     *
     * @Override
     */
    public function beforeSave($options = array()) {
        if ($this->log) {
            $this->logListernetData['event'] = $this->getEvent();
            $this->logListernetData['data'] = $this->data[$this->name];
        }
    }

    /**
     * Efetuar log de dados.
     * @Override
     */
    public function afterSave($created, $options = array()) {
        if (!$this->log)
            return;

        $this->logListernetData['data']['id'] = $this->data[$this->name]['id'];
        $this->listenerLog($this->logListernetData['event']);
    }

    /**
     * Efetuar log da ação no banco de dados.
     *
     * @param type $event qual ação que esta sendo executada.
     */
    public function listenerLog($event) {
        $this->logListernetData['user_id'] = SupportComponent::userId();
        $this->log(SupportComponent::toS($this->logListernetData), 'table_listener_' . $this->useTable);
    }

    function checkUnique($data, $fields) {
        if (!is_array($fields)) {
            $fields = array($fields);
        }
        foreach ($fields as $key) {
            $tmp[$key] = $this->data[$this->name][$key];
        }
        if (isset($this->data[$this->name][$this->primaryKey]) && $this->data[$this->name][$this->primaryKey] > 0) {
            $tmp[$this->primaryKey . " !="] = $this->data[$this->name][$this->primaryKey];
        }
        //return false;
        return $this->isUnique($tmp, false);
    }


    /**
     * Obtém o ID do último registro encontrado.
     * 
     * @param <string> $field
     * @param <array> $conditions
     */
    public function lastId($conditions = array(), $field = 'id') {
        $last = $this->find('first', array(
            'fields' => $field,
            'conditions' => $conditions,
            'order' => array(
                $field => 'desc'
            )
        ));

        return @$last[$this->name][$field] ?: 0;
    }

}
