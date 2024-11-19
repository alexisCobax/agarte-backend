<?php

use App\Modules\Producto\Controllers\ProductoController;

$router->get('/productos', [ProductoController::class, 'index']);
$router->get('/productos/{id}', [ProductoController::class, 'show']);
$router->post('/productos', [ProductoController::class, 'create']); 
$router->put('/productos/{id}', [ProductoController::class, 'update']); 
$router->delete('/productos/{id}', [ProductoController::class, 'delete']); 

