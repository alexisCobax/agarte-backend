<?php

namespace App\Modules\Presupuesto\Requests;

use App\Helpers\UserDataHelper;
use App\Helpers\ValidatorHelper;

class PresupuestosCreateRequest
{
    protected $data;

    public function __construct($data = [])
    {
        $this->data = $data;
        $this->validate();
    }

    // Métodos para obtener los campos

    public function getIdSucursal()
    {
        return !empty($this->data['id_sucursal']) ? $this->data['id_sucursal'] : 0;
    }

    public function getFecha()
    {
        return !empty($this->data['fecha']) ? $this->data['fecha'] : date('Y-m-d');
    }

    public function getIdCliente()
    {
        return !empty($this->data['id_cliente']) ? $this->data['id_cliente'] : 0;
    }

    public function getIdEstado()
    {
        return !empty($this->data['id_estado']) ? $this->data['id_estado'] : 0;
    }

    public function getIdEmpleado()
    {
        return !empty($this->data['id_empleado']) ? $this->data['id_empleado'] : 0;
    }

    public function getIdTipoEnmarcacion()
    {
        return !empty($this->data['id_tipo_enmarcacion']) ? $this->data['id_tipo_enmarcacion'] : 0;
    }

    public function getTotal()
    {
        return $this->data['total'] ?? 0;
    }

    public function getClienteNombre()
    {
        return $this->data['cliente_nombre'] ?? null;
    }

    public function getClienteTelefono()
    {
        return $this->data['cliente_telefono'] ?? null;
    }

    public function getClienteEmail()
    {
        return $this->data['cliente_email'] ?? null;
    }

    public function getClienteDomicilio()
    {
        return $this->data['cliente_domicilio'] ?? null;
    }

    public function getAlto()
    {
        return !empty($this->data['alto']) ? $this->data['alto'] : 0;
    }

    public function getAncho()
    {
        return !empty($this->data['ancho']) ? $this->data['ancho'] : 0;
    }

    public function getIdObjetoaEnmarcar()
    {
        return !empty($this->data['id_objeto_a_enmarcar']) ? $this->data['id_objeto_a_enmarcar'] : 0;
    }

    public function getComentarios()
    {
        return $this->data['comentarios'] ?? null;
    }

    public function getModelo()
    {
        return $this->data['modelo'] ?? null;
    }

    public function getPropio()
    {
        return !empty($this->data['propio']) ? $this->data['propio'] : 0;
    }

    public function getCreadoPor()
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