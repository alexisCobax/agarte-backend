<?php

namespace App\Modules\Empleado\Filters;

class FindFilter
{
    public static function getFilters(): array
    {
        $filters = [];

        /* Ejemplo */
        
        if (isset($_GET['nombre'])) {
            $filters[] = "empleados.nombre LIKE " . self::SQLformat('%' . $_GET['nombre'] . '%');
        }

        if (isset($_GET['email'])) {
            $filters[] = "empleados.email LIKE " . self::SQLformat('%' . $_GET['email'] . '%');
        }

        if (isset($_GET['id_sucursal'])) {
            $filters[] = "sucursales.id = " . $_GET['id_sucursal'];
        }

        $filters[] = "empleados.borrado IS NULL OR empleados.borrado != 1";

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
