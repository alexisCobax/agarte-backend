<?php

use App\Modules\Caja\Controllers\CajaController;
use App\Modules\Caja\Controllers\CajaDetalleController;

$router->get('/caja', [CajaController::class, 'index'], true);
$router->get('/caja/pdf/{id}', [CajaController::class, 'pdf'], false);
$router->get('/caja/{id}', [CajaController::class, 'show'], true);
$router->post('/caja', [CajaController::class, 'create'], true); 
$router->put('/caja/{id}', [CajaController::class, 'update'], true); 
$router->delete('/caja/{id}', [CajaController::class, 'delete'], true); 

$router->get('/caja_detalle', [CajaDetalleController::class, 'index'], true);
