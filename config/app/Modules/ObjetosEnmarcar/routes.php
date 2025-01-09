<?php

use App\Modules\ObjetosEnmarcar\Controllers\ObjetosEnmarcarController;

$router->get('/objetos_enmarcar', [ObjetosEnmarcarController::class, 'index'], true);
$router->get('/objetos_enmarcar/{id}', [ObjetosEnmarcarController::class, 'show'], true);
$router->post('/objetos_enmarcar', [ObjetosEnmarcarController::class, 'create'], true);
$router->put('/objetos_enmarcar/{id}', [ObjetosEnmarcarController::class, 'update'], true);
$router->delete('/objetos_enmarcar/{id}', [ObjetosEnmarcarController::class, 'delete'], true);
