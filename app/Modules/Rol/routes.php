<?php

use App\Modules\Rol\Controllers\RolController;

$router->get('/rol', [RolController::class, 'index'], true);
$router->get('/rol/{id}', [RolController::class, 'show'], true);
$router->post('/rol', [RolController::class, 'create'], true); 
$router->put('/rol/{id}', [RolController::class, 'update'], true); 
$router->delete('/rol/{id}', [RolController::class, 'delete'], true); 

