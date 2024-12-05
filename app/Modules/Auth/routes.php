<?php

use App\Modules\Auth\Controllers\AuthController;

$router->post('/auth/register', [AuthController::class, 'register']);
$router->post('/auth/login', [AuthController::class, 'login']); 
$router->post('/auth/logout', [AuthController::class, 'logout']);
$router->post('/auth/me', [AuthController::class, 'me'], true); 

