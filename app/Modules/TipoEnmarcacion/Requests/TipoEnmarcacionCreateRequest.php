<?php

namespace App\Modules\TipoEnmarcacion\Requests;

use App\Helpers\ValidatorHelper;

class TipoEnmarcacionCreateRequest
{
    protected $data;

    public function __construct($data = [])
    {
        $this->data = $data;
        $this->validate();
    }

    public function getNombre()
    {
        return $this->data['nombre'] ?? "";
    }

    public function getComisionFija()
    {
        return !empty($this->data['comisionFija']) ? $this->data['comisionFija'] : "0.00";
    }

    public function getComisionPorcentual()
    {
        return !empty($this->data['comisionPorcentual']) ? $this->data['comisionPorcentual'] : "0.00";
    }

    public function getSuspendido()
    {
        return $this->data['suspendido'] ?? "";
    }

    public function getIdSucursal()
    {
        return $this->data['id_sucursal'] ?? 0;
    }

    protected function validate()
    {
        $rules = [
//--
        ];

        // Validar los datos
        $errors = ValidatorHelper::validate($this->data, $rules);

        if (!empty($errors)) {
            echo json_encode($errors, true);
            exit;
        }
    }
}