<?php

if (!function_exists('pr')) {

    /**
     * Imprime um array de maneira mais visivel para o usuário.
     * 
     * @param array $array a ser impresso.
     */
    function pr($array) {
        $template = php_sapi_name() !== 'cli' ? '<pre>%s</pre>' : "\n%s\n";
        printf($template, print_r($array, true));
    }

}


if (!function_exists('array_last_branches')) {

    /**
     * Captura todos os últimos galhos de um Array 
     * independente de quantos sub-galhos o mesmo tenha.
     * 
     * @param array $array será capturado os últimos galhos deste array
     * @param array $match recipiente para os últimos galhos
     * @param int $cb número do galho atual
     */
    function array_last_branches(Array $array, &$match, $cb = 0) {
        foreach ($array as $key => $value)
            is_array($value) ? array_last_branches($value, $match, $cb++) : $match[$cb][] = $value;
    }

}