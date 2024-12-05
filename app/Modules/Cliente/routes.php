<?php

use App\Modules\Cliente\Controllers\ClienteController;

$router->get('/clientes', [ClienteController::class, 'index'], true);
$router->get('/clientes/{id}', [ClienteController::class, 'show'], true);
$router->post('/clientes', [ClienteController::class, 'create'], true); 
$router->put('/clientes/{id}', [ClienteController::class, 'update'], true); 
$router->delete('/clientes/{id}', [ClienteController::class, 'delete'], true); 

