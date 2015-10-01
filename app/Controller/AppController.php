<?php

# Pispop Business Name

define('PROJECT_NAME', basename(ROOT));
App::import('Vendor', 'Date');

class AppController extends Controller {

    /**
     * Define uma classe que representará a AppView
     *
     * @var string
     */
    public $viewClass = 'App';

    /**
     * Uma requestAction deve ser feita diretamente da VIEW, mas nada impede
     * um intruso requisitar a URL da requestAction direto do navegador.
     *
     * Para isso toda ação da request action deve verificar se este código
     * foi passado.
     *
     * @var string
     */
    public $requestCode = 'js71kqd1';

    /**
     * Componentes da aplicação e suas respectivas
     * configurações, instanciados para qualquer tipo de requisição.
     *
     * @var array
     */
    public $components = array(
        'Paginator', 'RequestHandler', 'Support', 'Auth', 'Session'
    );

    /**
     * Método referenciado antes de qualquer ação de
     * controllers filhos requisitados por url.
     */
    public function beforeFilter() {
//        $this->loadModel('User');
//        $this->User->pop();
        
//        die(AuthComponent::password('12345'));
        
        // Desativa as mensagens de erro da aplicação
         Configure::write('debug', true);

        // Configurações do componente de autenticação de usuário, Auth
        $this->authComponentConfig();

        // Efetuando o log de acesso de usuários.
        $this->logAccess();

        // Áreas que fazem uso da Hierarquia do usuário devem ser feitas após a
        // configuração do AuthComponent devido a AuthComponent::$sessionKey que
        // representa o índice da sessão de dados do usuário atual.
        //
        // Quando é requisitado o URL barra, o sistema redireciona para a página
        // inicial da hierarquia correspondente ao usuário atual do sistema.
        if (SupportComponent::route() == '/')
            $this->redirect('/' . SupportComponent::userHierarchy());

        // Verificando se um usuário está tentando acessar a área de outro.
        if ($this->request->prefix != SupportComponent::userHierarchy()) {
//            $this->Session->setFlash($this->components['Auth']['authError'], 'flash/mini/error');
            $this->redirect('/' . $this->hierarchy);
        }
    }

    /**
     * Configurações necessarias para o componente
     * de autenticação de usuário, AuthComponent
     */
    private function authComponentConfig() {
        // Índice onde será salvo as informações de sessão do usuário. Este deve
        // ser único, para que não ocorra colisão de sessões de outras aplicações
        // que utilizam está mesma base.
        // Pode-se basear pelo nome da aplicação e o IP do cliente.
        AuthComponent::$sessionKey = PROJECT_NAME . str_replace('.', '', $this->RequestHandler->getClientIp());

        $this->Auth->authenticate = array(
            AuthComponent::ALL => array(
                'userModel' => 'User',
                'fields' => array('username' => 'email'),
                'scope' => array('User.enable' => TRUE),
            ),
            'Form',
        );

        $this->Auth->authorize = 'Controller';
        $this->Auth->loginAction = array(
            'controller' => 'Users',
            'action' => 'login',
            'prefix' => 'visitor'
        );
        $this->Auth->logoutRedirect = array(
            'controller' => 'Users',
            'action' => 'login',
            'prefix' => 'visitor'
        );
        $this->Auth->flash['element'] = 'flash/mini/error';

        // Caso o prefixo de uma ação requisitada pela URL seja
        // igual a  hierarqui do usuaŕio, devemos permitir sua execução.
        if ($this->request->prefix == SupportComponent::userHierarchy())
            $this->Auth->allow($this->request->action);
    }

    // Método obrigatório pelo componente de autenticação, AuthComponent.
    public function isAuthorized() {
        return true;
    }

    /**
     * Destroi valores de request que não deviam estar sendo enviados.
     *
     * @param array $entites: [model => [allowField01, allowField02]
     */
    public function allowParams($entites) {
        $request_data = array();
        foreach ($entites as $entity => $params) {
            foreach ($params as $param) {
                if (array_key_exists($param, $this->request->data[$entity]))
                    $request_data[$entity][$param] = $this->request->data[$entity][$param];
            }
        }
        $this->request->data = $request_data;
    }

    /**
     * Envia um email a partir da variavel de configuração presente nesta clase
     * @param array $options = [to, template, viewVars]
     *
     * @return boolean
     */
    public function sendEmail($options = array()) {
        // Inicializando classe de e-mail caso ainda não tenha sido.
        if (empty($this->email)) {
            App::uses('CakeEmail', 'Network/Email');
            $this->email = new CakeEmail('liv');
        }

        // Inserindo novas opções passadas por parametro
        $this->email->config($options);

        return @$this->email->send();
    }

    /**
     * Ação referenciada no momento que ocorrer um erro qualquer no sistema.
     */
    public function _appError($error) {
        if ($error->getCode() == '404')
            $this->redirect('/');

        $this->layout = 'error';
        echo $this->render('generic');
        exit;
    }

    /**
     * Retorna JSON para uma chamada AJAX e finaliza a aplicação.
     *
     * @param ? $content valor a ser retornado.
     */
    public function returnJs($content) {
        echo json_encode($content);
        exit;
    }

    /**
     * Efetuando log de acessos dos usuários.
     *
     * @return void
     */
    private function logAccess() {
        $data = array(
            'user_id' => SupportComponent::userId(),
            'locate' => $this->name . '#' . $this->request->action,
            'get' => $this->request->params,
            'post' => $this->request->data
        );

        $this->log(SupportComponent::toS($data), 'access');
    }

    /**
     * Motedo request para efetuar a contagem de registros
     * do model corresponde ao controler da requisição.
     *
     * @return integer
     */
    public function admin_count() {
        $this->allowOnlyRequest();

        $model = $this->modelClass;
        return $this->$model->count();
    }

    /**
     * Verifica se a requisiçã atual é um requestAction válida.
     * Confere se o código da requisição é o mesmo de $this->requestCode.
     */
    protected function allowOnlyRequest() {
        $code = $this->request->params['code'];

        if ($code != $this->requestCode)
            $this->redirect('/');
    }

    /**
     * Ação privada para popular os dados da base de dados;
     */
    public function visitor_db() {
        $act = $this->request->param('act');

        // Modelos em que será aplicado a ação requisitada pela URL.
        $models = array(
            'pop' => array(
                'Holder'
            ),
            'restart' => array(
                'User', 'Issuer', '_Hash', 'Recharge'
            )
        );

        // Carregando modelos na aplicação.
        foreach ($models as $context)
            foreach ($context as $model)
                $this->loadModel($model);

        if ($act == 'pop') {
            foreach ($models['pop'] as $model) {
                // Inserindo registro no model caso não aind não tenha.
                if ($this->$model->count() == 0) {
                    $this->$model->pop();
                }

                // Busca registros inseridos
                @$entities[$model] = $this->$model->find();
            }

            $this->Session->setFlash('Banco de dados populado com sucesso. ' . json_encode($entities), 'flash/mini/success');
        } else if ($act == 'restart') {
            foreach ($models['restart'] as $model) {
                $table = $this->$model->useTable;
                $this->$model->query("DELETE FROM $table;");
                $this->$model->query("ALTER SEQUENCE {$table}_id_seq RESTART;");
                $this->Session->setFlash('Registros deletados, sequencia de ID\'s reiniciada.', 'flash/mini/success');
            }
        }

        $this->redirect('/');
    }

    public function getFilterAllow($params) {
        $formated_params = array();

        foreach ($params as $field)
            $formated_params[$field] = @$this->request->params['named'][$field];

        return $formated_params;
    }

    public function condition($fields, $key = 'filtro') {
        // Iniciando condições como vazias.
        $conditions = '';

        // Verificando se existe um filtro efetuado.
        if (array_key_exists($key, $_GET)) {

            // Verificando se o filtro efetuado está vazio.
            if (!empty($_GET[$key])) {

                // Capturando valor do filtro.
                $filter = $_GET[$key];

                $conditions .= '(';
                foreach (explode(',', $fields) as $field)
                    $conditions .= "$field ~* '$filter' OR";
                $conditions = substr($conditions, 0, -2) . ')';
            }
        }

        return $conditions;
    }

}
