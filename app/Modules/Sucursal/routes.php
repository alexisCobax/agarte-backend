<?php

use App\Modules\Sucursal\Controllers\SucursalController;

$router->get('/sucursales', [SucursalController::class, 'index']);
$router->get('/sucursales/{id}', [SucursalController::class, 'show']);
$router->post('/sucursales', [SucursalController::class, 'create']); 
$router->put('/sucursales/{id}', [SucursalController::class, 'update']); 
$router->delete('/sucursales/{id}', [SucursalController::class, 'delete']); 

