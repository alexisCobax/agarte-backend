<?php

namespace App\Modules\Empleado\Requests;

use App\Helpers\UserDataHelper;
use App\Helpers\ValidatorHelper;

class EmpleadosUpdateRequest
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

    public function getEmail()
    {
        return $this->data['email'] ?? null;
    }

    public function getTelefono()
    {
        return $this->data['telefono'] ?? null;
    }

    public function getIdSucursal()
    {
        return $this->data['id_sucursal'] ?? null;
    }

    public function getIdUsuario()
    {
        return $this->data['id_usuario'] ?? null;
    }

    public function setIdUsuario($idUsuario)
    {
        $this->data['id_usuario'] = $idUsuario;
    }

    public function getSuspendido()
    {
        return $this->data['suspendido'] ?? null;
    }

    public function getFechaAlta()
    {
        return $this->data['fecha_alta'] ?? null;
    }

    public function getCreadoPor()
    {
        $user = UserDataHelper::getUserData();
        return $user['user']['id'] ?? null;
    }

    public function getModificadoPor()
    {
        return $this->data['modificado_por'] ?? null;
    }

    public function getFechaBaja()
    {
        return $this->data['fecha_baja'] ?? null;
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