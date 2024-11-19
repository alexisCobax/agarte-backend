<?php

use App\Modules\Empleado\Controllers\EmpleadoController;

$router->get('/empleados', [EmpleadoController::class, 'index']);
$router->get('/empleados/{id}', [EmpleadoController::class, 'show']);
$router->post('/empleados', [EmpleadoController::class, 'create']); 
$router->put('/empleados/{id}', [EmpleadoController::class, 'update']); 
$router->delete('/empleados/{id}', [EmpleadoController::class, 'delete']); 

