<?php

use App\Modules\Orden\Controllers\OrdenController;

$router->get('/orden', [OrdenController::class, 'index']);
$router->get('/orden/{id}', [OrdenController::class, 'show']);
$router->post('/orden', [OrdenController::class, 'create']); 
$router->put('/orden/{id}', [OrdenController::class, 'update']); 
$router->delete('/orden/{id}', [OrdenController::class, 'delete']); 

