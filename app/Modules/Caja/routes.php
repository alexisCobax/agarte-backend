<?php

use App\Modules\Caja\Controllers\CajaController;

$router->get('/caja', [CajaController::class, 'index'], true);
$router->get('/caja/{id}', [CajaController::class, 'show'], true);
$router->post('/caja', [CajaController::class, 'create'], true); 
$router->put('/caja/{id}', [CajaController::class, 'update'], true); 
$router->delete('/caja/{id}', [CajaController::class, 'delete'], true); 

