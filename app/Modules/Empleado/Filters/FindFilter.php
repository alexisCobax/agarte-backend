<?php

namespace App\Modules\Empleado\Filters;

class FindFilter
{
    public static function getFilters(): array
    {
        $filters = [];

        /* Ejemplo */
        
        if (isset($_GET['nombre'])) {
            $filters[] = "empleados.nombre = " . self::SQLformat($_GET['nombre']);
        }

        if (isset($_GET['apellido'])) {
            $filters[] = "empleados.apellido = " . self::SQLformat($_GET['apellido']);
        }

        if (isset($_GET['id_sucursal'])) {
            $filters[] = "sucursales.id = " . self::SQLformat($_GET['id_sucursal']);
        }

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
