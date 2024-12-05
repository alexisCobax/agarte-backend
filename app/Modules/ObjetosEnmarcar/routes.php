<?php

use App\Modules\ObjetosEnmarcar\Controllers\ObjetosEnmarcarController;

$router->get('/ObjetosEnmarcar', [ObjetosEnmarcarController::class, 'index'], true);
$router->get('/ObjetosEnmarcar/{id}', [ObjetosEnmarcarController::class, 'show'], true);
$router->post('/ObjetosEnmarcar', [ObjetosEnmarcarController::class, 'create'], true);
$router->put('/ObjetosEnmarcar/{id}', [ObjetosEnmarcarController::class, 'update'], true);
$router->delete('/ObjetosEnmarcar/{id}', [ObjetosEnmarcarController::class, 'delete'], true);
