<?php

use App\Modules\Iva\Controllers\IvaController;

$router->get('/iva', [IvaController::class, 'index'], true);
// $router->get('/iva/{id}', [IvaController::class, 'show']);
// $router->post('/iva', [IvaController::class, 'create']); 
// $router->put('/iva/{id}', [IvaController::class, 'update']); 
// $router->delete('/iva/{id}', [IvaController::class, 'delete']); 

  