<?php

use App\Modules\Presupuesto\Controllers\PresupuestoController;
use App\Modules\Presupuesto\Controllers\PresupuestoDetalleController;
use App\Modules\Presupuesto\Controllers\PresupuestoExtrasController;

$router->get('/presupuestos', [PresupuestoController::class, 'index'], true);
$router->get('/presupuestos/{id}', [PresupuestoController::class, 'show'], true);

$router->post('/presupuestos', [PresupuestoController::class, 'createOrUpdate'], true); 
// $router->post('/presupuestos', [PresupuestoController::class, 'create'], true); 
// $router->put('/presupuestos/{id}', [PresupuestoController::class, 'update'], true); 

$router->delete('/presupuestos/{id}', [PresupuestoController::class, 'delete'], true); 

$router->get('/presupuestos_detalle', [PresupuestoDetalleController::class, 'index'], true);
$router->get('/presupuestos_detalle/{id}', [PresupuestoDetalleController::class, 'show'], true);
$router->post('/presupuestos_detalle', [PresupuestoDetalleController::class, 'create'], true); 
$router->put('/presupuestos_detalle/{id}', [PresupuestoDetalleController::class, 'update'], true); 
$router->delete('/presupuestos_detalle/{id}', [PresupuestoDetalleController::class, 'delete'], true); 

$router->post('/presupuestos_detalle/observaciones', [PresupuestoDetalleController::class, 'updateObservaciones'], true); 
$router->post('/presupuestos_detalle/posiciones', [PresupuestoDetalleController::class, 'updatePosiciones'], true); 
$router->post('/presupuestos_detalle/cm', [PresupuestoDetalleController::class, 'updateCm'], true); 
$router->post('/presupuestos_detalle/cs', [PresupuestoDetalleController::class, 'updateCs'], true); 

$router->get('/presupuestos_extras', [PresupuestoExtrasController::class, 'index'], true);
$router->get('/presupuestos_extras/{id}', [PresupuestoExtrasController::class, 'show'], true);
$router->post('/presupuestos_extras', [PresupuestoExtrasController::class, 'create'], true); 
$router->put('/presupuestos_extras/{id}', [PresupuestoExtrasController::class, 'update'], true); 
$router->delete('/presupuestos_extras/{id}', [PresupuestoExtrasController::class, 'delete'], true); 