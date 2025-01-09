<?php

namespace App\Modules\TipoMateriales\Requests;

use App\Helpers\ValidatorHelper;

class TipoMaterialesUpdateRequest
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

    public function getLogo()
    {
        return $this->data['logo'] ?? null;
    }

    public function getSuspendido()
    {
        return $this->data['suspendido'] ?? null;
    }

    public function getDomicilio()
    {
        return $this->data['domicilio'] ?? null;
    }

    public function getTelefono()
    {
        return $this->data['telefono'] ?? null;
    }

    protected function validate()
    {
        $rules = [
            'id' => 'required',
            'nombre' => 'required',
            'domicilio' => 'required',
            'telefono' => 'required'
        ];

        // Validar los datos
        $errors = ValidatorHelper::validate($this->data, $rules);

        if (!empty($errors)) {
            echo json_encode($errors, true);
            exit;
        }
    }
}