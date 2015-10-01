<?php

class SupportComponent extends Component {

    /**
     * Retorna a url atual de maneira padronizada
     *
     * @return type
     */
    public static function urlBase() {
        return Router::fullBaseUrl();
    }

    /**
     *
     * @return type
     */
    public static function appRoute() {
        return self::urlBase() . substr(Router::getRequest()->webroot, 0, -1);
    }

    /**
     * Retorna a url atual de maneira padronizada
     *
     * @return string url
     */
    public static function url() {
        return Router::url(null, true);
    }

    /**
     * Captura a routa atual da aplicação (mesma definida no arquivo de conf).
     *
     * @return string
     */
    public static function route() {
        return '/' . Router::getRequest()->url;
    }

    public static function routeBase() {
        $route = explode('&', self::route());
        $route = $route[0];
        
        $route_base = [];
        foreach (explode('/', $route) as $value) {
            if (is_numeric($value)) 
                break;
            
            if (stripos($value, ':')) {
                $value = explode(':', $value);
                $value = $value[0];
            }

            $route_base[] = $value;
        }

        return implode('/', $route_base);
    }

    public static function urlClear() {
        return substr(self::appRoute() . self::route(), 0, -1);
    }

    /**
     * Captura a URL do projeto
     * - protocol://project_server/project_name
     * - http://192.168.56.101/project_name/
     * - http://localhost/project_name/
     *
     * @return string url
     */
    public static function urlProjectFull() {
        $urlServer = Router::fullBaseUrl();
        $projectServerPath = Router::getPaths();

        return $urlServer . $projectServerPath['base'];
    }

    /**
     * Retorna a hierarquia do usuario atual.
     *
     * @return string nome da hierarquia.
     */
    public static function userHierarchy() {
        return CakeSession::read(AuthComponent::$sessionKey . '.hierarchy') ? : 'visitor';
    }

    /**
     * Retorna o ID do usuário, caso o mesmo esteja autenticado.
     *
     * @return int ID ou string 'unauthorized' caso não esteja autenticado.
     */
    public static function userId() {
        return CakeSession::read(AuthComponent::$sessionKey . '.id') ? : 'unauthorized';
    }

    /**
     * Transforma um array em objeto
     *
     * @return objectJson
     */
    public static function toObject($content) {
        return json_decode(json_encode($content), FALSE);
    }

    /**
     * Conver uma variavel em qualquer formato para string
     *
     * @return stringJson
     */
    public static function toS($content) {
        return json_encode($content);
    }

    /**
     * Retorna uma instancia de um determinado Controller.
     *
     * @param type $name
     * @return Controller
     */
    public static function getController($name) {
        App::import('Controller', $name);
        $controllerName = $name . 'Controller';
        return new $controllerName();
    }

    /**
     * Retorna uma instancia de um determinado Model.
     *
     * @param type $name
     * @return Controller
     */
    public static function getModel($modelName) {
        App::import('Model', $modelName);
        return new $modelName();
    }

    /**
     * Verifica se todos os servidores de passados por parametro estão no ar.
     * Se não estiver imediatamente é renderizado a View corresponte
     *
     * @return boolean
     */
    public static function isConnected() {
        App::uses('ConnectionManager', 'Model');

        foreach (func_get_args() as $dbConfig) {
            try {
                ConnectionManager::getDataSource($dbConfig);
            } catch (Exception $ex) {
                return false;
            }
        }

        return true;
    }

//    public static function closeConnections() {
//        App::uses('ConnectionManager', 'Model');
//
//        foreach (ConnectionManager::enumConnectionObjects() as $name => $config)
//            ConnectionManager::drop($name);
//    }
//
//    public static function dbClose() {
//        App::import('Model', 'ConnectionManager');
//        App::import('Model', 'DboSource');
//
//
//
//        foreach (ConnectionManager::sourceList() as $conn) {
//            $db = new DboSource($conn);
//            $db->disconnect();
//
//            ConnectionManager::getDataSource($conn)->close();
//            ConnectionManager::drop($conn);
//        }
//    }

    /**
     * Gera uma hash unica com o tamanho
     * informado por parametro, tamanho máximo de 50.
     *
     * @param int $tam tamanho da hash
     */
    public static function hash($tam = 16) {
        // verificando se o valor de $tam é válido, caso não seja será atribuido 50
        if ($tam > 50 || $tam < 0)
            $tam = 50;

        $hash = sha1(uniqid(rand(0, 10000), true));
        return substr($hash, 0, $tam);
    }

    public static function noAccents($str) {
        $str = htmlentities($str, ENT_COMPAT, 'UTF-8');
        $str = preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde|cedil);/', '$1', $str);
        return html_entity_decode($str);
    }

    public static function alphabetic($str) {
        $str = htmlentities($str, ENT_COMPAT, 'UTF-8');
        $str = preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde|cedil);/', '$1', $str);
        return html_entity_decode(strtolower(str_replace(' ', '', $str)));
    }

    /**
     * Mascará um string mask(05121994, '##/##/####)'
     *
     * @param type $string
     * @param type $mask
     * @return type
     */
    public function mask($string, $mask) {
        $string = str_replace(' ', '', $string);
        for ($i = 0; $i < strlen($string); $i++)
            $mask[strpos($mask, '#')] = $string[$i];
        return $mask;
    }

    /**
     * Substitui todos os caracteres de um string por algum outro pre-definido.
     *
     * my_string => *********
     *
     * @param type $str string que possuira seus caracters sobreescritos
     * @param type $replacement caracter que substituira
     * @return string string com caracteres sobreescritos
     */
    public static function replaceAll($str, $replacement = '*') {
        $str = preg_replace('/[ \t\n\r\f\v]/', $replacement, $str);
        return preg_replace('/\S/', $replacement, $str);
    }

    /**
     * Converte um valor no formato monetário (reais) para um valor FLOAT
     * reconhecivel em somas.
     * R$ 1.234.567,98 > 1234567.98
     *
     * @param type $money
     * @return float
     */
    public static function moneyToFloat($money) {
        $money = str_replace('.', '', $money);
        $money = str_replace(',', '.', $money);
        return preg_replace('/[^0-9\.]/', '', $money);
    }

    public static function floatToMoney($float) {
        return str_replace('.', ',', $float);
    }

    public static function months() {
        return array(
            'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun',
            'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'
        );
    }

    public static function dateFormal($date, $inputFormat = 'Y-m-d H:i') {
        App::uses('Date', 'Lib');
        $date = new Date($date, $inputFormat);
        return $date->formal();
    }

}
