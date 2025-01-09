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

    public function getId()
    {
        return !empty($this->data['id']) ? $this->data['id'] : 0;
    }

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
        return !empty($this->data['id_estado']) ? $this->data['id_estado'] : 1;
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
        return $this->data['cliente_nombre'] ?? '';
    }

    public function getClienteTelefono()
    {
        return $this->data['cliente_telefono'] ?? '';
    }

    public function getClienteEmail()
    {
        return $this->data['cliente_email'] ?? '';
    }

    public function getClienteDomicilio()
    {
        return $this->data['cliente_domicilio'] ?? '';
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
        return $this->data['comentarios'] ?? '';
    }

    public function getModelo()
    {
        return $this->data['modelo'] ?? '';
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

    public function getDescuento()
    {
        return !empty($this->data['descuento']) ? $this->data['descuento'] : 0;
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