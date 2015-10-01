<?php

App::uses('Model', 'Model');

class Replica {

    public $models = array(
        'Seller',
        'Accredited' => array(
            'useDbConfig' => 'petronius',
            'useTable' => 'accredited',
        )
    );
    public $direction = array(
        'Accredited' => array(
            'copyTo' => 'Seller',
            'fields' => array(
                'id' => 'id',
                'accreditedcorporatename' => 'corporate_name',
                'accreditedassumedname' => 'fantasy_name',
                'accreditedcnpj' => 'cnpj',
                'addresszipcode' => 'zipcode',
                'addressnumber' => 'number',
                'contactphonenumber' => 'phone',
                'contactemail' => 'email',
            )
        )
    );
    public $beforeSave = false;

    public function __construct() {
        die('oi');
    }

    private function prepareConfig() {
        foreach ($this->config as $model => $config) {
            if (is_int($model)) {
                $this->$config = new Model();
            }
        }
    }

}
