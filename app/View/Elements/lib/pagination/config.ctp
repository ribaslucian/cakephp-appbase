<?php

$url = explode('#', $url);

$paginator_options = array(
    'url' => array(
        'controller' => $url[0],
        'action' => $url[1]
    )
);

foreach ($this->passedArgs as $key => $value) {
    $paginator_options['url'][$key] = $value;
}

$this->Paginator->options($paginator_options);