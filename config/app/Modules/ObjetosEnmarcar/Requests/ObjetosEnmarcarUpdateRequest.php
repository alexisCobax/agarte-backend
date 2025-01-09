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
        return $this->data['extra_fijo'] ?? null;
    }

    public function getExtraPorcentual()
    {
        return $this->data['extra_porcentual'] ?? null;
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
