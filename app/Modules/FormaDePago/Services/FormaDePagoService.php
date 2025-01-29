<?php

namespace App\Modules\FormaDePago\Services;

use PDOException;
use App\Modules\FormaDePago\Repositories\FormaDePagoRepository;

class FormaDePagoService
{


    public function create($request): array
    {
        try {
            $FormaDePago = FormaDePagoRepository::create($request);
            return ["datos" => $FormaDePago];
        } catch (PDOException $e) {
            throw new \Exception('Error al crear un forma de pago. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {

        $FormaDePago = FormaDePagoRepository::find();

        if (!$FormaDePago) {
            throw new \Exception('No se encuentran forma de pago');
        }
        return $FormaDePago;
    }

    public function get($request): array
    {

        $FormaDePago = FormaDePagoRepository::findById($request->getId());

        if (!$FormaDePago) {
            throw new \Exception('No se encuentra Forma de Pago');
        }
        return $FormaDePago;
    }

    public function update($request): array
    {
        try {
            $FormaDePago = FormaDePagoRepository::update($request);
            if (!$FormaDePago) {
                throw new \Exception('Forma de Pago inexistente');
            }
            return $FormaDePago;
        } catch (PDOException $e) {
            throw new \Exception('Error al modificar una forma de pago. Inténtalo más tarde.');
        }
    }

    public function delete($request): bool
    {
        try {
            $FormaDePago = FormaDePagoRepository::delete($request);
            if (!$FormaDePago) {
                throw new \Exception('Forma de Pagoinexistente');
            }
            return $FormaDePago;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar una froma de pago. Inténtalo más tarde.');
        }
    }
}
