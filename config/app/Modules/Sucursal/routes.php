<?php

use App\Modules\Sucursal\Controllers\SucursalController;

$router->get('/sucursales', [SucursalController::class, 'index'], true);
$router->get('/sucursales/{id}', [SucursalController::class, 'show'], true);
$router->post('/sucursales', [SucursalController::class, 'create'], true); 
$router->put('/sucursales/{id}', [SucursalController::class, 'update'], true); 
$router->delete('/sucursales/{id}', [SucursalController::class, 'delete'], true); 

