<?php

namespace App\Modules\Presupuesto\Requests;

use App\Helpers\ValidatorHelper;

class PresupuestosDetalleCreateRequest
{
    protected $data;

    public function __construct($data = [])
    {
        $this->data = $data;
        $this->validate();
    }

    public function getIdPresupuesto()
    {
        return empty($this->data['id_presupuesto']) ? 0 : $this->data['id_presupuesto'];
    }

    public function setIdPresupuesto($idPresupuesto)
    {
        $this->data['id_presupuesto'] = $idPresupuesto;
    }

    public function getIdMaterial()
    {
        return $this->data['id_material'] ?? 0;
    }

    public function getCantidad()
    {
        return empty($this->data['cantidad']) ? 0 : $this->data['cantidad'];
    }

    public function getPosicion()
    {
        return $this->data['posicion'] ?? null;
    }

    public function getPrecioUnitario()
    {
        return $this->data['precio_unitario'] ?? 0;
    }

    public function getObservaciones()
    {
        return $this->data['observaciones'] ?? null;
    }

    public function getIdSucursal()
    {
        return empty($this->data['id_sucursal']) ? 0 : $this->data['id_sucursal'];
    }

    protected function validate()
    {
        $rules = [
            // Reglas de validación
        ];

        // Validar los datos
        $errors = ValidatorHelper::validate($this->data, $rules);

        if (!empty($errors)) {
            echo json_encode($errors, true);
            exit;
        }
    }
}