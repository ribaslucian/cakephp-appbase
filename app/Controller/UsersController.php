<?php

class UsersController extends AppController {

    public function admin_get() {
        $user = $this->User->find('first', $this->request->params['options']);

        return empty($user) ? false : $user;
    }

    /**
     * Ação responsável pelo login/autenticação de usuários.
     *
     * @return View /vistior/login.
     */
    public function visitor_login() {
        if ($this->request->is('post')) {
            
            $this->allowParams(array('User' => array('email', 'password')));

            if ($this->Auth->login())
                $this->redirect('/' . SupportComponent::userHierarchy());

            $this->Session->setFlash('Combinação de e-mail e senha é inválida.', 'flash/mini/error');
        }
    }

    /**
     * Ação responsável pela desautorização de um usuário ADMIN.
     *
     * @return View /vistior
     */
    public function admin_logout() {
        $this->Auth->logout();

        // Destruindo todas as sessões armazenadas.
        $this->Session->destroy();

        // Destruindo todas as conexões com banco de dados.
        SupportComponent::closeConnections();

        $this->redirect('/');
    }

    /**
     * Ação responsável apenas para a renderização da view que contém
     * os itens que irá auxiliar o usuário com em possíveis problemas.
     *
     * @return View visitor/help
     */
    public function visitor_help() {
        
    }

    /**
     * Ação responsável pela renderização da view ou auteração ou envio
     * de email para auteração da senha da conta de um determinado usuário.
     *
     * @return View /vistior/help/password_forgot ou / após o envio do e-mail.
     */
    public function visitor_password_forgot() {
        if ($this->request->is('post')) {

            $this->User->validate = array(
                'email' => array(
                    'rule' => 'email',
                    'message' => 'Este e-mail não é válido.'
                )
            );

            $this->User->set($this->request->data);
            if ($this->User->validates()) {
                // Buscando por um usuário correspondente ao e-mail informado.
                $hasUser = $this->User->find('first', array(
                    'fields' => 'id, enable',
                    'conditions' => array('email' => $this->request->data['User']['email'])
                ));

                // E-mail informado pertençe realmente à um usuário ?
                if (!empty($hasUser)) {

                    // Caso o mesmo tenha criado o usuário, porém não tenha confirmado;
                    if (empty($hasUser['User']['enable'])) {
                        $this->Session->setFlash('Seu usuário ainda não foi confirmado.', 'flash/mini/warning');
                        $this->redirect('/');
                    }

                    $this->loadModel('_Hash');
                    $hash = SupportComponent::hash();

                    // Buscando e deletando solicitações que já estão
                    // insipiradas OU solicitações que tenham sido feitas
                    // recentemente pelo usuário requisitante.
                    $this->_Hash->deleteInvalids(array(
                        "entity_id = {$hasUser['User']['id']}"
                    ));

                    // Criando registro indicativo da ação do
                    // usuário, armazenando (seu código de alteração).
                    $this->_Hash->create();
                    $this->_Hash->save(array(
                        'hash' => $hash,
                        'entity_id' => $hasUser['User']['id'],
                        'context' => 'password_forgot',
                    ));

                    // Enviando e-mail com a url para alteração da senha.
                    $this->sendEmail(array(
                        'to' => $this->request->data['User']['email'],
                        'template' => 'user/password_forgot',
                        'viewVars' => array(
                            'hash' => $hash
                        )
                    ));
                } else {
                    // Enviando e-mail informativo. E-mail não pertence a nenhum usuário.
                    $this->sendEmail(array(
                        'to' => $this->request->data['User']['email'],
                        'template' => 'user/not_found'
                    ));
                }

                $this->Session->setFlash('Em alguns instantes você receberá um e-mail com as informações necessárias para alterar sua senha.', 'flash/mini/success');
                $this->redirect('/visitor');
            }
        }

        $this->render('visitor/help/password_forgot');
    }

    /**
     * Após envio do e-mail para auteração da senha, o link interno
     * redirecionará o usuário para está ação e renderizará para a view
     * que contém o formulário para inserção da nova senha.
     *
     * @return View vistior/help/change_password ou / após o envio do e-mail
     */
    public function admin_user_edit() {
        $id = $this->Auth->user('id');

        if (empty($id))
            $this->redirect('/admin');

        if (empty($this->request->data)) {
            $this->request->data = $this->User->find('first', array(
                'fields' => array('id', 'name', 'birthday'),
                'conditions' => "id = $id"
                    )
            );

            $this->request->data['User']['birthday'] = new Date($this->request->data['User']['birthday'], 'Y-m-d', 'd-m-Y');
            $this->request->data['User']['birthday'] = $this->request->data['User']['birthday']->getDate();
        } else {
            // Definir usuário apenas se for a primeira referência desta ação.
            if ($this->request->is('put')) {
                
                if(!empty($this->request->data['User']['password'])){
                    if ($this->request->data['User']['password'] != $this->request->data['User']['password_confirm']) {
                        $this->Session->setFlash('As senhas devem ser iguais.', 'flash/mini/error');
                        $this->redirect('user_edit' . $this->request->params['id']);
                    }
                }else{
                    unset($this->request->data['User']['password']);
                    unset($this->request->data['User']['password_confirm']);
                }

                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash('Dados alterados com sucesso.', 'flash/mini/success');
                    $this->redirect('/admin');
                }

                $this->Session->setFlash('As senhas devem ser iguais.', 'flash/mini/error');
                $this->redirect('user_edit' . $this->request->params['id']);
            } else {
                $this->redirect('/admin');
            }
        }

        $this->render('admin/user_edit');
    }

    public function admin_change_password() {
        $id = $this->Auth->user('id');

        if (empty($id))
            $this->redirect('/admin');

        if (empty($this->request->data)) {
            $this->request->data = $this->User->find('first', array(
                'fields' => array('email', 'id'),
                'conditions' => "id = $id"
                    )
            );
        } else {
            // Definir usuário apenas se for a primeira referência desta ação.
            if ($this->request->is('put')) {
                //die(pr($this->request->data));
                if ($this->request->data['User']['password'] != $this->request->data['User']['password_confirm']) {
                    $this->Session->setFlash('As senhas devem ser iguais.', 'flash/mini/error');
                    $this->redirect('change_password' . $this->request->params['id']);
                }

                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash('Sua senha foi alterada com sucesso.', 'flash/mini/success');
                    $this->redirect('/admin');
                }
            } else {
                $this->redirect('/admin');
            }
        }

        $this->render('admin/change_password');
    }

    /**
     * Após a criação de um usuário será enviado um e-mail contendo o link para
     * confirmar o seu registro, este, redirecionará para está ação.
     *
     * @return View visitor/
     */
    public function visitor_confirm() {
        $hash = $this->request->param('hash');

        // Caso a URL tenha sido acessada sem passar um HASH.
        if (empty($hash))
            $this->redirect('/');

        $this->loadModel('_Hash');
        $user_id = $this->_Hash->getEntityId($hash, 'registration_confirm');

        // Caso a hash e contexto informado não chegue a nenhum usuário.
        if (empty($user_id))
            $this->redirect('/');

        $user = array(
            'id' => $user_id,
            'enable' => true,
        );

        // Se não for possível salvar o usuário;
        if (!$this->User->save($user)) {
            $this->log(json_encode($this->User->validationErrors), 'users_confirm_fail_save');
            $this->redirect('/');
        }

        // Deletando registro que representa a requisição de login do usuário
        $this->_Hash->deleteByHash($hash, 'registration_confirm');

        $this->Session->setFlash('Seu registro foi confirmado com sucesso, agora você já pode acessar sua conta.', 'flash/mini/success');
        $this->redirect('/');
    }

    /**
     * Apartir de um registro de usuáro no sistema, o mesmo entrará com seu
     * e-mail para receber o link de confirmação do seu registro.
     *
     * @return View vistior/help/resend_email_confirmation
     * ou / após o reenvio do e-mail
     */
    public function visitor_resend_email_confirmation() {
        if ($this->request->isPost()) {

            // Verificações que devem ser feitas:
            // O CNPJ enviado pertence a um contratante ?
            //  O contratante possui um usuario ?
            //   O usuario possui um registro de solicitacao ?
            // Verificando se o CNPJ foi preenchido corretamente
            if ($this->request->data['User']['cnpj']) {
                $this->loadModel('Issuer');

                // Buscando contratante referente a CNPJ do usuário
                $issuer = $this->Issuer->find('first', array(
                    'fields' => 'id',
                    'conditions' => array(
                        'cnpj' => $this->request->data['User']['cnpj']
                    )
                ));

                // Verificando se foi encontrado um Contratante
                if (!empty($issuer)) {
                    $user = $this->User->find('first', array(
                        'fields' => 'id, email',
                        'conditions' => array(
                            'issuer_id' => $issuer['Issuer']['id']
                        )
                    ));

                    // Verificando se existe um usuário corresponte ao
                    // contratante localizado pelo CNPJ do usuário.
                    if (!empty($user)) {
                        $this->loadModel('_Hash');

                        // Buscando registro de solicitação do usuário
                        $hash = $this->_Hash->find('first', array(
                            'fields' => 'hash',
                            'conditions' => array(
                                'entity_id' => $user['User']['id'],
                                'context' => 'registration_confirm',
                            )
                        ));

                        // Verificando se existe um HASH corresponte ao
                        // usuário localizado.
                        if (!empty($hash)) {

                            // Finalmente enviando o e-mail
                            $this->sendEmail(array(
                                'to' => $user['User']['email'],
                                'template' => 'user/registration_confirm',
                                'viewVars' => array(
                                    'hash' => $hash['_Hash']['hash']
                                )
                            ));

                            $this->Session->setFlash('
                                <div class="justify black color b" style="padding: 15px;">
                                    Em alguns instantes chegará um <span class="b3">e-mail</span> para você <br/>
                                    contendo as informações <span class="b3">necessárias</span> para acessar o <span class="b3">sistema</span>.
                                </div>

                                <div class="color smooth l small text">
                                    Verifique sua lixeira e caixa de spam.
                                </div>
                            ', 'flash/modal/success');
                        }

                        $this->redirect('/');
                    }
                }
            }

            $this->Session->setFlash('Não foi encontrado nenhum registro referente ao cnpj informado.', 'flash/mini/error');
            $this->redirect('/');
        }

        $this->render('visitor/help/resend_email_confirmation');
    }

    /**
     * Usuário envia um e-mail para nós descrevendo um possível problema;
     *
     * @return View vistior/help/other_problem ou / após o reenvio do e-mail
     */
    public function visitor_other_problem() {
        if ($this->request->is('post')) {
            $this->loadModel('Email');

            $this->Email->set($this->request->data);
            if ($this->Email->validates()) {

                // Enviando e-mail informativo. E-mail não pertence a nenhum usuário.
                $this->sendEmail(array(
//                    'to' => 'contato@livcard.com.br',
                    'to' => 'ribas.lucian@gmail.com',
                    'template' => 'user/help/other_problem',
                    'subject' => '[Liv] Área do Contrante | Problema de Usuário',
                    'viewVars' => array(
                        'name' => $this->request->data['Email']['name'],
                        'email' => $this->request->data['Email']['email'],
                        'description' => $this->request->data['Email']['description']
                    )
                ));

                $this->Session->setFlash('Agradecemos sua cooperação. Pedimos que tenha pasciência para nossa equipe identificar seu problema, logo retornamos uma solução.', 'flash/mini/success');
                $this->redirect('/');
            }
        }

        $this->render('visitor/help/other_problem');
    }

    /**
     * A partir de um código hash do modelo Hash, captura seu
     * respectivo usuário caso exista um registro na tabela.
     *
     * @param type $hash
     * @return {Model} user
     */
    private function getByHash($hash) {
        // Buscando pelo registro criado no
        // momento da solicitação de alteração de senha
        if (!$user_id = $this->_Hash->getEntityId($hash, 'password_forgot'))
            return false;

        // Buscando usuário relacionado ao registro de solicitação
        // e armazenando-o na na variavel de requisição para view.
        $user = $this->User->find('first', array('fields' => array('email'), 'conditions' => "id = $user_id"));

        if (empty($user))
            return false;

        // Atribuindo valores complementares ao usuário;
        $user['User']['id'] = $user_id;
        $user['User']['hash'] = $hash;
        return $user;
    }

    public function admin_send_photo() {
        
    }

}
