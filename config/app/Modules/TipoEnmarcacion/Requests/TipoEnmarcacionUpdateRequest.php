<?php

namespace App\Modules\TipoEnmarcacion\Requests;

use App\Helpers\ValidatorHelper;

class TipoEnmarcacionUpdateRequest
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

    public function getComisionFija()
    {
        return $this->data['comisionFija'] ?? null;
    }

    public function getComisionPorcentual()
    {
        return $this->data['comisionPorcentual'] ?? null;
    }

    public function getSuspendido()
    {
        return $this->data['suspendido'] ?? null;
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
