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
        return $this->data['id'] ?? 0;
    }

    public function getIdCliente()
    {
        return $this->data['id_cliente'] ?? 0;
    }

    public function getClienteNombre()
    {
        return $this->data['cliente_nombre'] ?? '';
    }
    public function getClienteEmail()
    {
        return $this->data['cliente_email'] ?? '';
    }
    public function getClienteDomicilio()
    {
        return $this->data['cliente_domicilio'] ?? '';
    }
    public function getClienteTelefono()
    {
        return $this->data['cliente_telefono'] ?? '';
    }

    public function getFecha()
    {
        return $this->data['fecha'] ?? null;
    }

    public function getTotal()
    {
        return $this->data['total'] ?? 0;
    }

    public function getIdOrdenDeTrabajo()
    {
        return $this->data['id_orden_de_trabajo'] ?? 0;
    }

    public function getIdFormaDePago()
    {
        return $this->data['id_forma_de_pago'] ?? 0;
    }

    public function getSuspendido()
    {
        return $this->data['suspendido'] ?? 0;
    }

    public function getCargadoPor()
    {
        return $this->data['cargado_por'] ?? 0;
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