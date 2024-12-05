<?php

use App\Modules\Orden\Controllers\OrdenController;

$router->get('/orden', [OrdenController::class, 'index'], true);
$router->get('/orden/{id}', [OrdenController::class, 'show'], true);
$router->post('/orden', [OrdenController::class, 'create'], true); 
$router->put('/orden/{id}', [OrdenController::class, 'update'], true); 
$router->delete('/orden/{id}', [OrdenController::class, 'delete'], true); 

