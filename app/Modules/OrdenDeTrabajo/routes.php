<?php

use App\Modules\OrdenDeTrabajo\Controllers\OrdenDeTrabajoController;
use App\Modules\OrdenDeTrabajo\Controllers\OrdenDeTrabajoEstadosController;

$router->get('/orden', [OrdenDeTrabajoController::class, 'index'], true);
$router->get('/orden/{id}', [OrdenDeTrabajoController::class, 'show'], true);
$router->post('/orden', [OrdenDeTrabajoController::class, 'create'], true); 
$router->put('/orden/{id}', [OrdenDeTrabajoController::class, 'update'], true); 
$router->delete('/orden/{id}', [OrdenDeTrabajoController::class, 'delete'], true); 

$router->get('/estados_orden_trabajo', [OrdenDeTrabajoEstadosController::class, 'index'], true);
$router->get('/estados_orden_trabajo/{id}', [OrdenDeTrabajoEstadosController::class, 'show'], true);
$router->post('/estados_orden_trabajo', [OrdenDeTrabajoEstadosController::class, 'create'], true); 
$router->put('/estados_orden_trabajo/{id}', [OrdenDeTrabajoEstadosController::class, 'update'], true); 
$router->delete('/estados_orden_trabajo/{id}', [OrdenDeTrabajoEstadosController::class, 'delete'], true); 

