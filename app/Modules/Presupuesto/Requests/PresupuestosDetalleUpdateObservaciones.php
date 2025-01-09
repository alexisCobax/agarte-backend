<?php

namespace App\Modules\Presupuesto\Requests;

use App\Helpers\ValidatorHelper;

class PresupuestosDetalleUpdateObservaciones
{
    protected $data;

    public function __construct($data = [])
    {
        $this->data = $data;
        $this->validate();
    }

    public function getId()
    {
        return $this->data['id_presupuesto_detalle'] ?? 0;
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