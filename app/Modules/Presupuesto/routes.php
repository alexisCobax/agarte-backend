<?php

use App\Modules\Presupuesto\Controllers\PresupuestoController;
use App\Modules\Presupuesto\Controllers\PresupuestoDetalleController;

$router->get('/presupuestos', [PresupuestoController::class, 'index'], true);
$router->get('/presupuestos/{id}', [PresupuestoController::class, 'show'], true);
$router->post('/presupuestos', [PresupuestoController::class, 'create'], true); 
$router->put('/presupuestos/{id}', [PresupuestoController::class, 'update'], true); 
$router->delete('/presupuestos/{id}', [PresupuestoController::class, 'delete'], true); 

$router->get('/presupuestos_detalle', [PresupuestoDetalleController::class, 'index'], true);
$router->get('/presupuestos_detalle/{id}', [PresupuestoDetalleController::class, 'show'], true);
$router->post('/presupuestos_detalle', [PresupuestoDetalleController::class, 'create'], true); 
$router->put('/presupuestos_detalle/{id}', [PresupuestoDetalleController::class, 'update'], true); 
$router->delete('/presupuestos_detalle/{id}', [PresupuestoDetalleController::class, 'delete'], true); 
