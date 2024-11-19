<?php

use App\Modules\Usuario\Controllers\UsuarioController;

$router->get('/usuarios', [UsuarioController::class, 'index']);
$router->get('/usuarios/{id}', [UsuarioController::class, 'show']);
$router->post('/usuarios', [UsuarioController::class, 'create']); 
$router->put('/usuarios/{id}', [UsuarioController::class, 'update']); 
$router->delete('/usuarios/{id}', [UsuarioController::class, 'delete']); 

