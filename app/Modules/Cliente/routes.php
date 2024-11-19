<?php

use App\Modules\Cliente\Controllers\ClienteController;

$router->get('/clientes', [ClienteController::class, 'index']);
$router->get('/clientes/{id}', [ClienteController::class, 'show']);
$router->post('/clientes', [ClienteController::class, 'create']); 
$router->put('/clientes/{id}', [ClienteController::class, 'update']); 
$router->delete('/clientes/{id}', [ClienteController::class, 'delete']); 

