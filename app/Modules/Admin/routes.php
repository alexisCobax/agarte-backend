<?php

use App\Modules\Admin\Controllers\AdminController;

$router->get('/admin', [AdminController::class, 'home']);

$router->get('/admin/roles', [AdminController::class, 'roles']);
$router->get('/admin/roles/abm/{id}', [AdminController::class, 'rolesABM']);
$router->post('/admin/roles/createOrUpdate', [AdminController::class, 'gestionarRoles']);



$router->get('/admin/permisos', [AdminController::class, 'permisos']);
$router->get('/admin/permisos/abm/{id}', [AdminController::class, 'permisosABM']);
$router->post('/admin/permisos/createOrUpdate', [AdminController::class, 'gestionarPermisos']);


