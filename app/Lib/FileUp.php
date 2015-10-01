<?php

class FileUp {

    /**
     * Representa as extensões de arquivos que será permitida o upload.
     *
     * @var array
     */
    public $allowExt = array(
        'jpg', 'gif', 'png'
    );

    /**
     * Diretório onde será salvo os arquivos enviados.
     *
     * @var string
     */
    public $saveIn = null;

    /**
     * Número máximo de arquivos que podem ser enviados.
     *
     * @var int
     */
    public $maxFiles = 10;

    /**
     * Número mínimo de arquivos que devem ser enviados.
     *
     * @var int
     */
    public $minFiles = 1;

    /**
     * Tamanho máximo em MB que será permitido para arquivo enviado.
     *
     * @var float
     */
    public $maxSize = 10;

    /**
     * Representa os arquivos que foram enviados pro servidor de
     * maneira adaptada, deixando mais simples e limpo a variável.
     *
     * @var array
     */
    public $files = array();

    /**
     * Conterá as mensagens de error caso ocorram,
     * onde o índice representará o arquivo afetado.
     *
     * @var array
     */
    public $errors = array();

    /**
     * Total de arquivos enviados.
     *
     * @var int
     */
    public $total = 0;

    /**
     * Construtor genérico para definir os
     * valores dos attributos apartir de um array.
     *
     * @param array $config seu indice representa o atributo.
     * @return void
     */
    public function __construct(array $config = array()) {
        foreach ($config as $attribute => $value)
            $this->$attribute = $value;

        // area não genérica
        $this->setFiles();
    }

    /**
     * Define os dados todos os arquivos os arquivos enviados ao
     * atributo $this->files, percorrendo os indices de $_FILES e
     * retirando oque não é necessário.
     *
     * @return void
     */
    private function setFiles() {

        // Caso nenhum arquivo tenha sido enviado
        if (empty($_FILES))
            return;

        // função não primitiva do PHP, deve-se ser implementada.
        array_last_branches($_FILES, $branches);

        $this->files['name'] = $branches[0];
        $this->files['type'] = $branches[1];
        $this->files['tmp_name'] = $branches[2];
        $this->files['error'] = $branches[3];
        
        // o tamanho do arquivo primitivo vem em KB, aqui o convertemos para MB
        $this->files['size'] = array_map(function($value) {
            return round(($value / 1024) / 1024, 2);
        }, $branches[4]);

        // Percorrenco arquivos para definir alguns valores básicos, 
        // tais como extensão, nome e caminho que será salvo;
        foreach ($this->files['name'] as $key => $value) {
            $value = explode('.', $value);
            // caso não seja encontrada um extesão regular será atribuido null.
            $this->files['extension'][$key] = count($value) == 1 ? null : $value[count($value) - 1];
            
            // Definindo hash que representará o nome dos arquivos salvos em disco
            $this->files['hash'][$key] = $this->getHash();
            
            // definindo caminho que o arquivo será salvo.
            $this->files['path'][$key] = $this->saveIn . $this->files['hash'][$key] . '.' . $this->files['extension'][$key];
        }

        // Definindo o total de arquivos
        $this->total = @count($this->files['tmp_name']);
    }

    /**
     * Captura os arquivos enviados para o servidor de forma resumida.
     *
     * @return array
     */
    public function getFiles() {
        return $this->files;
    }

    /**
     * Verifica se os arquivos enviados são validos.
     *
     * @return bool
     */
    public function valid() {
        $this->validate();
        return empty($this->errors);
    }

    /**
     * Efetua a contagem do total de arquivos válidos
     * enviados, guarda este valor em $this->total.
     *
     * @return void
     */
    private function validate() {
        // Menos arquivo que o permitido ?
        if ($this->total < $this->minFiles)
            $this->errors[] = "Selecione no mínimo $this->minFiles arquivo(s).";

        // Mais arquivo que o permitido ?
        if ($this->total > $this->maxFiles)
            $this->errors[] = "Selecione no máximo $this->minFiles arquivo(s).";

        // Verificando se as extenções dos arquivos são válidas 
        // ou está faltando parte de algum arquivo enviado.
        for ($i = $this->total - 1; $i >= 0; $i--) {
            // Nome  é válido ?
            /* if (empty($this->files['name'][$i]))
              $this->errors[] = "O tipo do arquivo '{$this->files['name'][$i]}' é inválido.";

              // Tipo é válido ?
              if (empty($this->files['type'][$i]))
              $this->errors[] = "O tipo do arquivo '{$this->files['name'][$i]}' é inválido.";

              // Está vazio ?
              if ($this->files['size'][$i] <= 0)
              $this->errors[] = "O arquivo '{$this->files['name'][$i]}' não possui conteúdo.";
             */

            // Sua extensão é permitida ?
            if (!in_array($this->files['extension'][$i], $this->allowExt))
                $this->errors[] = "O arquivo '{$this->files['name'][$i]}' está em um formato inválido.";
        }
        array_reverse($this->errors);
    }

    /**
     * Define um error e retira um arquivo inválido da classe.
     *
     * @param int $key a chave do arquivo que ocorre o erro.
     * @param type $type é o tipo de erro que ocorreu.
     *
     * @return void
     */
    private function setError($type) {
        $this->errors[] = $this->errorMessageModel[$type];
    }

    /**
     * Verifica se um determinada extensão representa um imagem.
     *
     * @param type $extension
     * @return bool
     */
    private function isImage($extension) {
        return in_array($extension, array('img', 'png', 'gif'));
    }

    /**
     * Salva os arquivos enviados.
     */
    public function save() {
        // Verificando se não há nenhum rompimento de restrição.
        if (!$this->valid())
            return false;

        // criando pasta que será salvo os arquivos (caso não exista).
        if (!file_exists($this->saveIn)) {
            if (!@mkdir($this->saveIn, 0777, true))
                return false;
        }

        // Percorrendo arquivos e salvando.
        foreach ($this->files['tmp_name'] as $key => $tmp) {
            // Nome do arquivo que será salvo
            @$targetName =  $this->files['hash'][$key] . '.' . $this->files['extension'][$key];
            
            // Movendo arquivos enviados
            if (!move_uploaded_file($tmp, $this->saveIn . $targetName)) 
                return false;
        }
        
        return true;
    }

    /**
     * Gera um hash unica que representará o nome de um arquivo salvo
     *
     * @return string hash
     */
    public function getHash() {
        return md5(uniqid(rand(), true));
    }

}
