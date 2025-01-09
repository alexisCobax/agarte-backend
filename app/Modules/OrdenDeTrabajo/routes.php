<?php

use App\Modules\OrdenDeTrabajo\Controllers\OrdenDeTrabajoController;

$router->get('/orden', [OrdenDeTrabajoController::class, 'index'], true);
$router->get('/orden/{id}', [OrdenDeTrabajoController::class, 'show'], true);
$router->post('/orden', [OrdenDeTrabajoController::class, 'create'], true); 
$router->put('/orden/{id}', [OrdenDeTrabajoController::class, 'update'], true); 
$router->delete('/orden/{id}', [OrdenDeTrabajoController::class, 'delete'], true); 

