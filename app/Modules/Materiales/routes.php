<?php

use App\Modules\Materiales\Controllers\MaterialesController;

$router->get('/materiales', [MaterialesController::class, 'index'], true);
$router->get('/materiales/{id}', [MaterialesController::class, 'show'], true);
$router->post('/materiales', [MaterialesController::class, 'create'], true); 
$router->put('/materiales/{id}', [MaterialesController::class, 'update'], true); 
$router->delete('/materiales/{id}', [MaterialesController::class, 'delete'], true); 

