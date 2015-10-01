<?php

class _Validation {

    public static function generic($string) {
        return (empty($string) ? true : preg_match('/^[0-9,a-z,A-Z,á-ú,Á-Ú,à-ù,À-Ù,ã-õ,Ã-Õ,â-û,Â-Û,ä-ü,Ä-Ü,\.,\º,\ª,\-,\:,[:space:]]{0,512}$/', $string));
    }

    public static function name($name, $expression = '|^[a-z çá-úà-ù]*$|i') { //'|^[a-z çá-úà-ù]{0,92}$|i'
        return preg_match($expression, $name);
    }

    public static function grade($grade, $expression = '|^[a-z 0-9 çá-úà-ù]*$|i') { //'|^[a-z çá-úà-ù]{0,92}$|i'
        return preg_match($expression, $grade);
    }

    public static function cpf($cpf, $expression = '|^[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}$|') {
        if (empty($cpf))
            return true;
        return preg_match($expression, $cpf);
    }

    public static function rg($rg, $expression = '|[0-9]{0,16}|') {
        return preg_match($expression, $rg);
    }

    public static function cep($cep, $expression = '|^[0-9]{5}-[0-9]{3}$|') {
        return preg_match($expression, $cep);
    }

    public static function phone($phone, $expression = '|^\([0-9]{2}\) [0-9]{4}-[0-9]{4}$|') {
        return preg_match($expression, $phone);
    }

    public static function email($phone, $expression = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/') {
        return preg_match($expression, $phone);
    }

    public static function cnpj($cnpj, $expression = '|^[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}\-[0-9]{2}$|') {
        return preg_match($expression, $cnpj);
    }

    public static function cpfRule($cpf) {
        // Verifica se um número foi informado
        if (empty($cpf))
            return false;

        // Elimina possivel mascara
        $cpf = ereg_replace('[^0-9]', '', $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        // Verifica se o numero de digitos informados é igual a 11 
        if (strlen($cpf) != 11)
            return false;

        // Verifica se nenhuma das sequências invalidas abaixo 
        // foi digitada. Caso afirmativo, retorna falso
        else if ($cpf == '00000000000' || $cpf == '11111111111' ||
                $cpf == '22222222222' || $cpf == '33333333333' ||
                $cpf == '44444444444' || $cpf == '55555555555' ||
                $cpf == '66666666666' || $cpf == '77777777777' ||
                $cpf == '88888888888' || $cpf == '99999999999') {
            return false;
        } else {
            // Calcula os digitos verificadores para verificar se o
            // CPF é válido
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++)
                    $d += $cpf{$c} * (($t + 1) - $c);

                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d)
                    return false;
            }

            return true;
        }
    }

}
