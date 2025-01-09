<?php

namespace App\Modules\Recibo\Requests;

use App\Helpers\ValidatorHelper;

class RecibosUpdateRequest
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

    public function getIdCliente()
    {
        return $this->data['id_cliente'] ?? null;
    }

    public function getFecha()
    {
        return $this->data['fecha'] ?? null;
    }

    public function getTotal()
    {
        return $this->data['total'] ?? null;
    }

    public function getIdOrdenDeTrabajo()
    {
        return $this->data['id_orden_de_trabajo'] ?? null;
    }

    public function getIdFormaDePago()
    {
        return $this->data['id_forma_de_pago'] ?? null;
    }

    public function getSuspendido()
    {
        return $this->data['suspendido'] ?? null;
    }

    public function getCargadoPor()
    {
        return $this->data['cargado_por'] ?? null;
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