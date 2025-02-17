<?php

namespace App\Modules\Cliente\Requests;

use App\Helpers\UserDataHelper;
use App\Helpers\ValidatorHelper;

class ClientesCreateRequest
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

    public function getDomicilio()
    {
        return $this->data['domicilio'] ?? '';
    }

    public function getIdLocalidad()
    {
        return $this->data['id_localidad'] ?? 0;
    }

    public function getEmail()
    {
        return $this->data['email'] ?? '';
    }

    public function getTelefono()
    {
        return $this->data['telefono'] ?? '';
    }

    public function getIdTipoDocumento()
    {
        return $this->data['id_tipo_documento'] ?? 0;
    }

    public function getDocumento()
    {
        return $this->data['documento'] ?? '';
    }

    public function getIdCondicionIva()
    {
        return $this->data['id_condicion_iva'] ?? 0;
    }

    public function getdescuento()
    {
        return !empty($this->data['descuento']) ? $this->data['descuento'] : "0.00";
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
        $data['fecha_baja'] = !empty($this->data['fecha_baja']) ? $this->data['fecha_baja'] : null;
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
