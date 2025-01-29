<?php

namespace App\Modules\ReciboDetalle\Requests;

use App\Helpers\ValidatorHelper;

class RecibosDetalleCreateRequest
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
        return $this->data['id'] ?? 0;
    }

    public function getIdRcibo()
    {
        return $this->data['id_recibo'] ?? 0;
    }

    public function getIdFormaDePago()
    {
        return $this->data['id_forma_de_pago'] ?? 0;
    }
    public function getMonto()
    {
        return $this->data['monto'] ?? 0;
    }
    public function getObservaciones()
    {
        return $this->data['observaciones'] ?? '';
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