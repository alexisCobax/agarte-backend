<?php

namespace App\Modules\OrdenDeTrabajoDetalles\Requests;

use App\Helpers\ValidatorHelper;

class OrdenDeTrabajoDetallesUpdateRequest
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

    public function getIdOrdenDeTrabajo()
    {
        return $this->data['id_orden_de_trabajo'] ?? null;
    }

    public function getIdProducto()
    {
        return $this->data['id_producto'] ?? null;
    }

    public function getCantidad()
    {
        return $this->data['cantidad'] ?? null;
    }

    public function getPosicion()
    {
        return $this->data['posicion'] ?? null;
    }

    public function getComentarios()
    {
        return $this->data['comentarios'] ?? null;
    }

    public function getPrecio()
    {
        return $this->data['precio'] ?? null;
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