<?php

use App\Modules\rol\Controllers\rolController;

$router->get('/rol', [rolController::class, 'index'], true);
$router->get('/rol/{id}', [rolController::class, 'show'], true);
$router->post('/rol', [rolController::class, 'create'], true); 
$router->put('/rol/{id}', [rolController::class, 'update'], true); 
$router->delete('/rol/{id}', [rolController::class, 'delete'], true); 

