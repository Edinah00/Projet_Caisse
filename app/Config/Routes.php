<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */// Auth
$routes->get('/',           'AuthController::login');
$routes->post('/login',     'AuthController::doLogin');
$routes->get('/logout',     'AuthController::logout');

$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/caisse',            'CaisseController::choisir');
    $routes->post('/caisse',           'CaisseController::valider');
    $routes->get('/achats',            'AchatController::index');
    $routes->post('/achats/ajouter',   'AchatController::ajouter');
    $routes->post('/achats/cloturer',  'AchatController::cloturer');
    $routes->get('/achats/ticket', 'AchatController::ticket');
    $routes->get('/historique', 'HistoriqueController::index');
});
