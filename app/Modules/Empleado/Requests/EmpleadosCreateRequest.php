<?php

namespace App\Modules\Empleado\Requests;

use App\Helpers\UserDataHelper;
use App\Helpers\ValidatorHelper;

class EmpleadosCreateRequest
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
        return $this->data['id'] ?? 0;
    }

    public function getNombre()
    {
        return $this->data['nombre'] ?? '';
    }

    public function getEmail()
    {
        return $this->data['email'] ?? '';
    }

    public function getTelefono()
    {
        return $this->data['telefono'] ?? '';
    }

    public function getIdSucursal()
    {
        return $this->data['id_sucursal'] ?? 0;
    }

    public function getIdUsuario()
    {
        return $this->data['id_usuario'] ?? 0;
    }

    public function setIdUsuario($idUsuario)
    {
        $this->data['id_usuario'] = $idUsuario;
    }

    public function getSuspendido()
    {
        return $this->data['suspendido'] ?? 0;
    }

    public function getFechaAlta()
    {
        return !empty($this->data['fecha_alta']) ? $this->data['fecha_alta'] : date('Y-m-d');
    }

    public function getCreadoPor()
    {
        $user = UserDataHelper::getUserData();
        return $user['user']['id'] ?? 0;
    }

    public function getModificadoPor()
    {
        $user = UserDataHelper::getUserData();
        return $user['user']['id'] ?? 0;
    }

    public function getFechaBaja()
    {
        $data['fecha_baja'] = !empty($this->data['fecha_baja']) ? $this->data['fecha_baja'] :  date('Y-m-d');
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