<?php

namespace App\Modules\Empleado\Services;

use PDOException;
use App\Modules\Empleado\Repositories\EmpleadosRepository;
use App\Modules\Auth\Services\AuthService;

class EmpleadosService
{
    public function create($requestEmpleados, $authRequest): array
    {
        try {
            $auth = new AuthService();
            $usuario = $auth->register($authRequest);

            $requestEmpleados->setIdUsuario($usuario['id']);

            $item = EmpleadosRepository::create($requestEmpleados);
            return ["datos" => $item];
        } catch (PDOException $e) {
            throw new \Exception('Error al crear un empleado. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {
        $items = EmpleadosRepository::find();

        if (!$items) {
            throw new \Exception('No se encuentran empleados.');
        }
        return $items;
    }

    public function get($request): array
    {
        $item = EmpleadosRepository::findById($request->getId());

        if (!$item) {
            throw new \Exception('No se encuentra empleados.');
        }
        return $item;
    }

    public function update($requestEmpleados, $authRequest): array
    {
        try {
            $auth = new AuthService();
            $empleados = EmpleadosRepository::findById($requestEmpleados->getId());
            $authRequest->setId($empleados['id_usuario']);
            $requestEmpleados->setIdUsuario($empleados['id_usuario']);
            if($authRequest->getClave()=='vacio'){
                $auth->updateUser($authRequest);
            }else{
                $auth->update($authRequest);
            }
            $item = EmpleadosRepository::update($requestEmpleados);
            if (!$item) {
                throw new \Exception('Empleado inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al modificar unn empleados. Inténtalo más tarde.');
        }
    }

    public function delete($request): bool
    {
        try {
            $item = EmpleadosRepository::delete($request);
            if (!$item) {
                throw new \Exception('Empleado inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar un empleado. Inténtalo más tarde.');
        }
    }
}