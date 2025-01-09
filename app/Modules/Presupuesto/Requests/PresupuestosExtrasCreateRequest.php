<?php

namespace App\Modules\Presupuesto\Requests;

use App\Helpers\ValidatorHelper;

class PresupuestosExtrasCreateRequest
{
    protected $data;

    public function __construct($data = [])
    {
        $this->data = $data;
        $this->validate();
    }

    public function getId()
    {
        return $this->data['id'] ?? 0;
    }

    public function getIdPresupuesto()
    {
        return empty($this->data['id_presupuesto']) ? 0 : $this->data['id_presupuesto'];
    }

    public function setIdPresupuesto($idPresupuesto)
    {
        $this->data['id_presupuesto'] = $idPresupuesto;
    }

    public function getDescripcion()
    {
        return $this->data['descripcion'] ?? "";
    }

    public function getCantidad()
    {
        return $this->data['cantidad'] ?? 0;
    }


    public function getPrecioUnitario()
    {
        return $this->data['precio_unitario'] ?? 0;
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