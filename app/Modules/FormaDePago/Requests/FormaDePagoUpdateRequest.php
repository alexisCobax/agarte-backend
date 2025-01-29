<?php

namespace App\Modules\FormaDePago\Requests;

use App\Helpers\ValidatorHelper;

class FormaDePagoUpdateRequest
{
    protected $data;

    public function __construct($data = [])
    {
        $this->data = $data;
        $this->validate();
    }

    public function getId()
    {
        return $this->data['id'] ?? 0;
    }

    public function getNombre()
    {
        return $this->data['nombre'] ?? '';
    }

    public function suspendido()
    {
        return $this->data['suspendido'] ?? 0;
    }

    protected function validate()
    {
        $rules = [
            'id' => 'required',
            'nombre' => 'required',
            'suspendido' => 'required'
        ];

        // Validar los datos
        $errors = ValidatorHelper::validate($this->data, $rules);

        if (!empty($errors)) {
            echo json_encode($errors, true);
            exit;
        }
    }
}