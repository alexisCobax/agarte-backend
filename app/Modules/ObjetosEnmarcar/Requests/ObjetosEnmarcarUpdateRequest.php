<?php

namespace App\Modules\ObjetosEnmarcar\Requests;

use App\Helpers\ValidatorHelper;

class ObjetosEnmarcarUpdateRequest
{
    protected $data;

    public function __construct($data = [])
    {
        $this->data = $data;
        $this->validate();
    }

    public function getId()
    {
        return $this->data['id'] ?? null;
    }

    public function getNombre()
    {
        return $this->data['nombre'] ?? null;
    }

    public function getExtraFijo()
    {
        return !empty($this->data['extra_fijo']) ? $this->data['extra_fijo'] : "0.00";
    }

    public function getExtraPorcentual()
    {
        return !empty($this->data['extra_porcentual']) ? $this->data['extra_porcentual'] : "0.00";
    }

    public function getIdSucursal()
    {
        return $this->data['id_sucursal'] ?? 0;
    }

    protected function validate()
    {
        $rules = [];

        // Validar los datos
        $errors = ValidatorHelper::validate($this->data, $rules);

        if (!empty($errors)) {
            echo json_encode($errors, true);
            exit;
        }
    }
}
