<?php

namespace App\Helpers;

class LogHelper
{
    private static $logFile = __DIR__ . '/../../public/storage/logs/app.log';  // Ruta del archivo de log

    /**
     * Escribe un mensaje de log en el archivo especificado
     *
     * @param string $message  El mensaje de log
     * @param string $level    Nivel del log (INFO, ERROR, WARNING, etc.)
     */
    public static function log(string $message, string $level = 'INFO')
    {
        $timestamp = date('Y-m-d H:i:s');  // Timestamp del mensaje
        $formattedMessage = "[{$timestamp}] [{$level}] {$message}" . PHP_EOL;

        // Escribir en el archivo de log
        file_put_contents(self::$logFile, $formattedMessage, FILE_APPEND);
    }

    /**
     * Log de nivel INFO
     *
     * @param string $message
     */
    public static function info(string $message)
    {
        self::log($message, 'INFO');
    }

    /**
     * Log de nivel ERROR
     *
     * @param string $message
     */
    public static function error(string $message)
    {
        self::log($message, 'ERROR');
    }

    /**
     * Log de nivel WARNING
     *
     * @param string $message
     */
    public static function warning(string $message)
    {
        self::log($message, 'WARNING');
    }

    /**
     * Log de nivel DEBUG
     *
     * @param string $message
     */
    public static function debug(string $message)
    {
        self::log($message, 'DEBUG');
    }
}

