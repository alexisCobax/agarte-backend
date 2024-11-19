<?php

namespace App\Exceptions;

use App\Helpers\LogHelper;

class DatabaseException extends \Exception
{
    public function __construct($message = "Error en la base de datos", $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);

        // Llamamos al método de LogHelper para registrar el error
        $this->logError();
    }

    // Método para registrar el error
    private function logError()
    {
        // Crear un mensaje de log con detalles importantes
        $logMessage = 'Database Error: ' . $this->message . ' | Fecha: ' . date('Y-m-d');

        // Usamos LogHelper para registrar el error
        LogHelper::error($logMessage);
    }
}