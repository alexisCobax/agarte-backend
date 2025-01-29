<?php

use App\Modules\FormaDePago\Controllers\FormaDePagoController;

$router->get('/forma_de_pago', [FormaDePagoController::class, 'index'], true);
$router->get('/forma_de_pago/{id}', [FormaDePagoController::class, 'show'], true);
$router->post('/forma_de_pago', [FormaDePagoController::class, 'create'], true); 
$router->put('/forma_de_pago/{id}', [FormaDePagoController::class, 'update'], true); 
$router->delete('/forma_de_pago/{id}', [FormaDePagoController::class, 'delete'], true); 

