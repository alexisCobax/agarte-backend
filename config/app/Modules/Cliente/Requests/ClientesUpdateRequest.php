<?php

namespace App\Modules\Cliente\Requests;

use App\Helpers\UserDataHelper;
use App\Helpers\ValidatorHelper;

class ClientesUpdateRequest
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

    public function getNombre()
    {
        return $this->data['nombre'] ?? null;
    }

    public function getDomicilio()
    {
        return $this->data['domicilio'] ?? null;
    }

    public function getIdLocalidad()
    {
        return $this->data['id_localidad'] ?? null;
    }

    public function getEmail()
    {
        return $this->data['email'] ?? null;
    }

    public function getTelefono()
    {
        return $this->data['telefono'] ?? null;
    }

    public function getIdTipoDocumento()
    {
        return $this->data['id_tipo_documento'] ?? null;
    }

    public function getDocumento()
    {
        return $this->data['documento'] ?? null;
    }

    public function getIdCondicionIva()
    {
        return $this->data['id_condicion_iva'] ?? null;
    }

    public function getModificadoPor()
    {
        $user = UserDataHelper::getUserData();
        return $user['user']['id'] ?? null;
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