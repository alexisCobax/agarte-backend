<?php

namespace App\Modules\Presupuesto\Requests;

use App\Helpers\UserDataHelper;
use App\Helpers\ValidatorHelper;

class PresupuestosUpdateRequest
{
    protected $data;

    public function __construct($data = [])
    {
        $this->data = $data;
        $this->validate();
    }

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
        $user = UserDataHelper::getUserData();
        return $user['user']['id'] ?? null;
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

    public function getSubtotal()
    {
        return !empty($this->data['subtotal']) ? $this->data['subtotal'] : 0;
    }

    public function getDescuento()
    {
        return !empty($this->data['descuento']) ? $this->data['descuento'] : 0;
    }

    public function getModificadoPor()
    {
        $user = UserDataHelper::getUserData();
        return $user['user']['id'] ?? null;
    }

    public function getEstadoOrdenTrabajo()
    {
        return !empty($this->data['descuento']) ? $this->data['descuento'] : 0;
    }

    public function getCantidad()
    {
        return !empty($this->data['cantidad']) ? $this->data['cantidad'] : 1;
    }

    /**
     * Implementación del método toArray
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'id_sucursal' => $this->getIdSucursal(),
            'fecha' => $this->getFecha(),
            'id_cliente' => $this->getIdCliente(),
            'id_estado' => $this->getIdEstado(),
            'id_empleado' => $this->getIdEmpleado(),
            'id_tipo_enmarcacion' => $this->getIdTipoEnmarcacion(),
            'comentarios' => $this->getComentarios(),
            'total' => $this->getTotal(),
            'cliente_nombre' => $this->getClienteNombre(),
            'cliente_telefono' => $this->getClienteTelefono(),
            'cliente_email' => $this->getClienteEmail(),
            'cliente_domicilio' => $this->getClienteDomicilio(),
            'alto' => $this->getAlto(),
            'ancho' => $this->getAncho(),
            'id_objeto_a_enmarcar' => $this->getIdObjetoaEnmarcar(),
            'modelo' => $this->getModelo(),
            'propio' => $this->getPropio(),
            'modificado_por' => $this->getModificadoPor(),
            'sub_total' => $this->getSubtotal(),
            'descuento' => $this->getDescuento(),
            'cantidad' => $this->getCantidad(),
            'estado_orden_trabajo' => $this->getEstadoOrdenTrabajo()
        ];
    }

    protected function validate()
    {
        $rules = [
            // Validaciones personalizadas
        ];

        $errors = ValidatorHelper::validate($this->data, $rules);

        if (!empty($errors)) {
            echo json_encode($errors, true);
            exit;
        }
    }
}
