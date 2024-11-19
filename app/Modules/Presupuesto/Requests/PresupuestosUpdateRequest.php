<?php

namespace App\Modules\Presupuesto\Requests;

use App\Helpers\ValidatorHelper;

class PresupuestosUpdateRequest
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

    public function getIdSucursal()
    {
        return $this->data['id_sucursal'] ?? null;
    }

    public function getFacha()
    {
        return $this->data['facha'] ?? null;
    }

    public function getIdCliente()
    {
        return $this->data['id_cliente'] ?? null;
    }

    public function getIdEstado()
    {
        return $this->data['id_estado'] ?? null;
    }

    public function getTotal()
    {
        return $this->data['total'] ?? null;
    }

    public function getIdVendedor()
    {
        return $this->data['id_vendedor'] ?? null;
    }

    public function getIdTipoEnmarcacion()
    {
        return $this->data['id_tipo_enmarcacion'] ?? null;
    }

    public function getIdTipoViidrio()
    {
        return $this->data['id_tipo_viidrio'] ?? null;
    }

    public function getComentarios()
    {
        return $this->data['comentarios'] ?? null;
    }

    public function getCreadoPor()
    {
        return $this->data['creado_por'] ?? null;
    }

    public function getModificadoPor()
    {
        return $this->data['modificado_por'] ?? null;
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