<?php

use App\Modules\TipoEnmarcacion\Controllers\TipoEnmarcacionController;

$router->get('/tipo_enmarcacion', [TipoEnmarcacionController::class, 'index'], true);
$router->get('/tipo_enmarcacion/{id}', [TipoEnmarcacionController::class, 'show'], true);
$router->post('/tipo_enmarcacion', [TipoEnmarcacionController::class, 'create'], true);
$router->put('/tipo_enmarcacion/{id}', [TipoEnmarcacionController::class, 'update'], true);
$router->delete('/tipo_enmarcacion/{id}', [TipoEnmarcacionController::class, 'delete'], true);
