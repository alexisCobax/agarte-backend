<?php

use App\Modules\Localidades\Controllers\LocalidadesController;

$router->get('/localidades', [LocalidadesController::class, 'index'], true);
// $router->get('/localidades/{id}', [LocalidadesController::class, 'show']);
// $router->post('/localidades', [LocalidadesController::class, 'create']); 
// $router->put('/localidades/{id}', [LocalidadesController::class, 'update']); 
// $router->delete('/localidades/{id}', [LocalidadesController::class, 'delete']); 

