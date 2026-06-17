<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */// Auth
$routes->get('/',           'AuthController::login');
$routes->post('/login',     'AuthController::doLogin');
$routes->get('/logout',     'AuthController::logout');

// Choix caisse
$routes->get('/caisse',     'CaisseController::choisir');
$routes->post('/caisse',    'CaisseController::valider');

// Achats
$routes->get('/achats',           'AchatController::index');
$routes->post('/achats/ajouter',  'AchatController::ajouter');
$routes->post('/achats/cloturer', 'AchatController::cloturer');