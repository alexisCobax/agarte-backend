<?php

use App\Modules\Presupuesto\Controllers\PresupuestoController;

$router->get('/presupuestos', [PresupuestoController::class, 'index']);
$router->get('/presupuestos/{id}', [PresupuestoController::class, 'show']);
$router->post('/presupuestos', [PresupuestoController::class, 'create']); 
$router->put('/presupuestos/{id}', [PresupuestoController::class, 'update']); 
$router->delete('/presupuestos/{id}', [PresupuestoController::class, 'delete']); 

