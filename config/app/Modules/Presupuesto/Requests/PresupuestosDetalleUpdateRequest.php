<?php

namespace App\Modules\Presupuesto\Requests;

use App\Helpers\ValidatorHelper;

class PresupuestosDetalleUpdateRequest
{
    protected $data;

    public function __construct($data = [])
    {
        $this->data = $data;
        $this->validate();
    }

    // Métodos para obtener los campos
    public function getId()
    {
        return $this->data['id'] ?? null;
    }

    public function getIdPresupuesto()
    {
        return $this->data['id_presupuesto'] ?? null;
    }

    public function getIdProducto()
    {
        return $this->data['id_producto'] ?? null;
    }

    public function getCantidad()
    {
        return $this->data['cantidad'] ?? null;
    }

    public function getPosicion()
    {
        return $this->data['posicion'] ?? null;
    }

    public function getPrecio()
    {
        return $this->data['precio'] ?? null;
    }

    public function getObservaciones()
    {
        return $this->data['observaciones'] ?? null;
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