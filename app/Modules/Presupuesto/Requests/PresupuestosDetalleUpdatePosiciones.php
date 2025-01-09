<?php

namespace App\Modules\Presupuesto\Requests;

use App\Helpers\ValidatorHelper;

class PresupuestosDetalleUpdatePosiciones
{
    protected $data;

    public function __construct($data = [])
    {
        $this->data = $this->decodeJson($data);
        $this->validate();
    }

    public function getPosiciones()
    {
        return array_values(array_filter($this->data, 'is_numeric'));
    }
    
    
    protected function validate()
    {
        $rules = [
            //
        ];

        // Validar los datos
        $errors = ValidatorHelper::validate(['posiciones' => $this->data], $rules);

        if (!empty($errors)) {
            echo json_encode($errors, true);
            exit;
        }
    }

    private function decodeJson($data)
    {
        // Si $data es un JSON string, decodificarlo
        if (is_string($data)) {
            $decoded = json_decode($data, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded;
            } else {
                echo json_encode(['error' => 'Invalid JSON received'], true);
                exit;
            }
        }

        // Si ya es un arreglo, retornarlo tal cual
        return $data;
    }
}
