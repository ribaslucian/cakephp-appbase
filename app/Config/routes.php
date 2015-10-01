<?php

// Rotas iniciais de hierarquias (redirecionada após autenticação do usuário).
Router::connect('/visitor', array('controller' => 'Users', 'action' => 'login', 'prefix' => 'visitor'));

// admin
Router::connect('/admin', array('controller' => 'Overview', 'prefix' => 'admin'));
//Router::connect('/admin/issuers/', array('controller' => 'Issuers', 'prefix' => 'index'));

Router::connect('/admin/benefitassigments/getEntityAlias', array('controller' => 'benefitassigments', 'action' => 'getEntityAlias', 'prefix' => 'admin'));
Router::connect('/admin/benefitassigments/getEntityName', array('controller' => 'benefitassigments', 'action' => 'getEntityName', 'prefix' => 'admin'));

// management
Router::connect('/admin/management/cardshistory', array('controller' => 'Management', 'action' => 'cards_history', 'prefix' => 'admin'));
Router::connect('/admin/management/transactionsperday', array('controller' => 'Management', 'action' => 'transactions_per_day', 'prefix' => 'admin'));
Router::connect('/admin/management/transactionspermonth', array('controller' => 'Management', 'action' => 'transactions_per_month', 'prefix' => 'admin'));
Router::connect('/admin/management/totalissuers', array('controller' => 'Management', 'action' => 'total_issuers', 'prefix' => 'admin'));

//------------------------------------------------------------------------------

CakePlugin::routes();
require CAKE . 'Config' . DS . 'routes.php';
