<?php

namespace App\Modules\Cliente\Filters;

class FindFilter
{
    public static function getFilters(): array
    {
        $filters = [];
        
        if (isset($_GET['nombre'])) {
            $filters[] = "nombre LIKE " . self::SQLformat('%' . $_GET['nombre'] . '%');
        }
        if (isset($_GET['telefono'])) {
            $filters[] = "telefono LIKE " . self::SQLformat('%' . $_GET['telefono'] . '%');
        }
        if (isset($_GET['domicilio'])) {
            $filters[] = "domicilio LIKE " . self::SQLformat('%' . $_GET['domicilio'] . '%');
        }

        $filters[] = "borrado IS NULL OR borrado != 1";

        return $filters;
    }
    

    /* 
     *Esta funcion es para cuando viene un string 
     *lo envie con comillas dobles y no de un error en la consulta
     */

    private static function SQLformat($value): string
    {
        // Verifica si el valor es un string
        if (is_string($value)) {
            return '"' . $value . '"';
        }
        // Si no es un string, lo retorna tal cual
        return $value;
    }
}
