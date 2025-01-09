<?php

namespace App\Modules\TipoEnmarcacion\Requests;

use App\Helpers\ValidatorHelper;

class TipoEnmarcacionDeleteRequest
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

    protected function validate()
    {
        $rules = [
            'id' => 'required'
        ];

        // Validar los datos
        $errors = ValidatorHelper::validate($this->data, $rules);

        if (!empty($errors)) {
            echo json_encode($errors, true);
            exit;
        }
    }
}