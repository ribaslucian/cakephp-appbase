<?php

class ShowHelper extends AppHelper {

    # Retira os sobrenomes e deixa apenas a 1º letra maiúscula
    public function name($name) {
        $name = explode(' ', $name);
        echo ucfirst(strtolower($name[0]));
    }

    # Efetua a separação dos valores por ',' (virgula) e depois '.' (ponto)
    public function money($money, $format = '<a class="mini button basic"><span class="b">R$ </span>%s</a>') {
        return str_replace('%s', number_format($money, 2, ',', '.'), $format);
    }

    public function email($email, $format = '<span class="i">&#60;%s&#62;</span>') {
        return str_replace('%s', $email, $format);
    }

    # Multiplica o valor por 100
    public function percent($value, $format = '<a class="mini circular button basic"><span class="b">% </span>%s</a>') {
        return str_replace('%s', $this->notZerosRight($value), $format);
        #return '<span class="b">% </span>' . $value * 10;
        #return '<a class="blue circular small label"><span class="b">% </span>' . $value * 10 . '</a>';
    }

    # Efetua a separação dos valores por ',' (virgula) e depois '.' (ponto)
    public function date($date, $show_hours = false) {
        if($show_hours != false):
            $date = explode(' ', $date);
            $hour = $date[1];
            $date = explode('-', $date[0]);
            return $date[2] . '/' . $date[1] . '/' . $date[0] . ' ' . ($show_hours ? substr($hour, 0, 5) : '');
        else:
            $date = explode('-', $date);
            return $date[2] . '/' . $date[1] . '/' . $date[0];
        endif;
    }

    # Efetua a separação dos valores por ',' (virgula) e depois '.' (ponto)
    public function dateExplode($date) {
        $date = explode(' ', $date);
        $moment = explode(':', $date[1]);
        $date = explode('-', $date[0]);

        $dateExplode['day'] = $date[2];
        $dateExplode['month'] = $date[1];
        $dateExplode['year'] = $date[0];
        $dateExplode['hour'] = $moment[0];
        $dateExplode['minute'] = $moment[1];

        return $dateExplode;
    }

    # Retira os zeros da direita de determinados valores
    public function notZerosRight($number) {
        if ($number != 0) {
            $number = rtrim(number_format($number, 4, ',', '.'), 0);
            if (substr($number, -1) == '.') {
                return substr($number, 0, -1);
            }
        }
        return $number;
    }
}