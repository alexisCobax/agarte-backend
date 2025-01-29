<?php

namespace App\Modules\Rol\Requests;

use App\Helpers\ValidatorHelper;

class RolCreateRequest
{
    protected $data;

    public function __construct($data = [])
    {
        $this->data = $data;
        $this->validate();
    }

    public function getNombre()
    {
        return $this->data['nombre'] ?? '';
    }

    
    public function getSuspendido()
    {
        return $this->data['suspendido'] ?? 0;
    }

    public function getId()
    {
        return $this->data['id'] ?? 0;
    }

    protected function validate()
    {
        $rules = [
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