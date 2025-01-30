<?php

namespace App\Modules\Caja\Services;

use PDOException;
use App\Modules\Caja\Repositories\CajasRepository;
use App\Modules\Auth\Services\AuthService;

class CajasService
{
    public function create($requestCajas): array
    {
        try {
            $auth = new AuthService();
            
            
            $requestCajas->setIdUsuario($usuario['id']);

            $item = CajasRepository::create($requestCajas);
            return ["datos" => $item];
        } catch (PDOException $e) {
            throw new \Exception('Error al crear un Caja. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {
        $items = CajasRepository::find();

        if (!$items) {
            throw new \Exception('No se encuentran Cajas.');
        }
        return $items;
    }

    public function get($request): array
    {
        $item = CajasRepository::findById($request->getId());

        if (!$item) {
            throw new \Exception('No se encuentra Cajas.');
        }
        return $item;
    }

    public function update($requestCajas, $authRequest): array
    {
        try {
            $auth = new AuthService();
            $Cajas = CajasRepository::findById($requestCajas->getId());
            $authRequest->setId($Cajas['id_usuario']);
            $requestCajas->setIdUsuario($Cajas['id_usuario']);
            if($authRequest->getClave()=='vacio'){
                $auth->updateUser($authRequest);
            }else{
                $auth->update($authRequest);
            }
            $item = CajasRepository::update($requestCajas);
            if (!$item) {
                throw new \Exception('Caja inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al modificar unn Cajas. Inténtalo más tarde.');
        }
    }

    public function delete($request): bool
    {
        try {
            $item = CajasRepository::delete($request);
            if (!$item) {
                throw new \Exception('Caja inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar un Caja. Inténtalo más tarde.');
        }
    }
}