<?php

namespace App\Helpers;

class RenderHelper
{
    public static function render($view, $data = [])
    {
        // Extraer las variables del arreglo asociativo
        extract($data);
    
        // Dividir el nombre de la vista en partes usando el punto como separador
        $parts = explode('.', $view);
    
        // Asegurar que las partes estén en mayúsculas
        $parts = array_map('ucfirst', $parts);
    
        // Reconstruir la ruta con las partes modificadas
        $viewPath = implode('/', $parts) . '.view.php';

        // Construir la ruta completa de la vista, empezando desde la carpeta base del proyecto
        $viewFile = dirname(__DIR__, 1) . '/Modules/' . $viewPath;

        // Verificar que el archivo de vista existe
        if (!file_exists($viewFile)) {
            throw new \Exception("View file not found: $viewFile");
        }
    
        // Capturar la salida del archivo de vista
        ob_start();
        include $viewFile;
        echo ob_get_clean();
    }
}
