<?php

use App\Modules\Recibo\Controllers\ReciboController;

$router->get('/recibos', [ReciboController::class, 'index']);
$router->get('/recibos/{id}', [ReciboController::class, 'show']);
$router->post('/recibos', [ReciboController::class, 'create']); 
$router->put('/recibos/{id}', [ReciboController::class, 'update']); 
$router->delete('/recibos/{id}', [ReciboController::class, 'delete']); 

