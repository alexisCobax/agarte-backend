<?php

use App\Modules\Recibo\Controllers\ReciboController;

$router->get('/recibos', [ReciboController::class, 'index'], true);
$router->get('/recibos/{id}', [ReciboController::class, 'show'], true);
$router->post('/recibos', [ReciboController::class, 'create'], true); 
$router->get('/recibos/pdf/{id}', [ReciboController::class, 'pdfRecibo'], true);
$router->put('/recibos/{id}', [ReciboController::class, 'update'], true); 
$router->delete('/recibos/{id}', [ReciboController::class, 'delete'], true); 

