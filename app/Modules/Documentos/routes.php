<?php

use App\Modules\Documentos\Controllers\DocumentosController;

$router->get('/documentos', [DocumentosController::class, 'index'], true);
// $router->get('/documentos/{id}', [DocumentosController::class, 'show']);
// $router->post('/documentos', [DocumentosController::class, 'create']); 
// $router->put('/documentos/{id}', [DocumentosController::class, 'update']); 
// $router->delete('/documentos/{id}', [DocumentosController::class, 'delete']); 

