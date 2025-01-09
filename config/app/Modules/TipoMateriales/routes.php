<?php

use App\Modules\TipoMateriales\Controllers\TipoMaterialesController;

$router->get('/tipo_materiales', [TipoMaterialesController::class, 'index'], true);
$router->get('/tipo_materiales/{id}', [TipoMaterialesController::class, 'show'], true);
$router->post('/tipo_materiales', [TipoMaterialesController::class, 'create'], true); 
$router->put('/tipo_materiales/{id}', [TipoMaterialesController::class, 'update'], true); 
$router->delete('/tipo_materiales/{id}', [TipoMaterialesController::class, 'delete'], true); 

