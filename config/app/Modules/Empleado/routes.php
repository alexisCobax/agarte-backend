<?php

use App\Modules\Empleado\Controllers\EmpleadoController;

$router->get('/empleados', [EmpleadoController::class, 'index'], true);
$router->get('/empleados/{id}', [EmpleadoController::class, 'show'], true);
$router->post('/empleados', [EmpleadoController::class, 'create'], true); 
$router->put('/empleados/{id}', [EmpleadoController::class, 'update'], true); 
$router->delete('/empleados/{id}', [EmpleadoController::class, 'delete'], true); 

