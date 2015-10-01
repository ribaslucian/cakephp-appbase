<?php

class AppView extends View {

    public $requestCode;
    public $actionShort;

    /**
     * Sobreescrita do construtor, para incrementar algumas chamadas iniciais
     * @param \Controller $controller
     */
    public function __construct(\Controller $controller = null) {
        parent::__construct($controller);
        $this->controller = $controller;

        // Definindo a hierarquia do usuário atual.
        $this->hierarchy = SupportComponent::userHierarchy();
        $this->requestCode = $controller->requestCode;
        $this->setActionShort();

        // Definindo uma variavel com os dados do usuário conectado
        $this->set('user', SupportComponent::toObject($controller->Auth->user()));
    }

    /**
     * Define o nome da ação atual sem o prefixo do usuário, caso exista
     *
     * @return string
     */
    public function setActionShort() {
        $action = explode('_', $this->request->action);

        if (array_key_exists(1, $action))
            unset($action[0]);

        $this->actionShort = implode('_', $action);
    }

    /**
     * Adaptação na função do core para o uso das pastas hierarquicas
     *
     * @return CakeViewRender
     */
    public function render($view = null, $layout = null) {
        if (empty($view))
            $view = $this->name == 'Home' ? $this->hierarchy : $this->hierarchy . '/' . $this->actionShort;

        return parent::render($view, $layout);
    }

    /**
     * Captura uma URL para a página anterior caso a mesma esteja configurada.
     * Arquivo de configuração: {YourApp}/Config/menu_back.php
     *
     * @return string url
     */
    public function back() {
        require_once APP . 'Config' . DS . 'menu_back.php';
        return @$back[SupportComponent::routeBase()] ? : null;
//        return @$back[$this->name][$this->request->action] ? : null;
    }

    public function request($url, $options = array()) {
        $options['code'] = $this->requestCode;
        return $this->requestAction($url, $options);
    }

    /**
     * Baseado na ação corrente, é retornado o nome do método
     * que um determinado formulário deve utiliza no momento do
     * envio de dados. Necessário para o Controlador identificar
     * que tipo de alteração a requisição pretende efetuar.
     *
     * @return string nome do método
     */
    public function getMethod() {
        $action = $this->actionShort;

        if ($action == 'edit')
            return 'PUT';

        if ($action == 'delete')
            return 'DELETE';
        return 'POST';
    }

    public function getUserName() {
        $name = explode(' ', AuthComponent::user('name'));
        return strtolower($name[0]);
    }

    public function buttonDelete($id, $options = []) {

        // Preparando atributos do formulário
        $commons = [
            'hierarchy' => 'admin',
            'model' => Inflector::singularize($this->name),
            'controller' => $this->name
        ];
        $options = array_merge($commons, $options);
        $options['controller'] = strtolower($options['controller']);
        @$options['url'] = $options['url'] ? : "/{$options['hierarchy']}/{$options['controller']}/delete";


        $html = $this->Form->create($model, [
            'url' => $url,
            'method' => 'DELETE'
        ]);
        $html = $this->Form->hidden('id', $id);
        $html = $this->Form->submit('Deletar');
        $html .= $this->Form->end();
    }

    public function quickFilter($url, $key = 'filtro') {
        return '<form method="GET" action="' . $url . '">
            <div class="ui icon small input jq_filter">
                <input name="filtro" type="text" autofocus="1" value="' . (@$_GET[$key] ? : '') . '" class="shadow jq_filter">
                <i class="search icon"></i>
            </div>
        </form>';
    }
    
    public function benefitassigments_color_class_by_entity($entity) {
        if ($entity == 'issuers') {
            return 'bg teal';
        } else if ($entity == 'holders') {
            return 'bg brown';
        } else if ($entity == 'sellers') {
            return 'bg green';
        } else if ($entity == 'cards') {
            return 'bg orange';
        }
    }
}
