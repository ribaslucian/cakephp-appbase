<?php

App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel {
    
    public $useTable = 'users';

    /**
     * Método que irá inserir um usuário básico na tabela, para testes;
     */
    public function pop() {
        $this->validate = false;
        
        $user = array(
            'email' => 'root@email.com',
            'password' => 'root',
            'enable' => true,
            'hierarchy' => 'admin',
        );
        
        if (!$this->save($user))
            pr($this->validationErrors);
    }

    /**
     * @Override
     * 
     * Regras para criação de um usário, como salva a senha criptografada;
     */
    public function beforeSave($options = array()) {
        parent::beforeSave($options);

        // Criptografando a Senha 
        // Caso a senha venha vazia não será feira nem uma criptografia
        if (!empty($this->data['User']['password']))
            $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);

        if (!empty($this->data['User']['email']))
            $this->data['User']['email'] = mb_strtolower($this->data['User']['email']);

        return true;
    }

}
