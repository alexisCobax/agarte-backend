<?php

namespace App\Modules\Materiales\Filters;

class FindFilter
{
    public static function getFilters(): array
    {
        $filters = [];
        
        if (isset($_GET['id_tipo_material'])) {
            $filters[] = "materiales.id_tipo_material = " . $_GET['id_tipo_material'];
        }

        if (isset($_GET['nombre'])) {
            $filters[] = "materiales.nombre LIKE " . self::SQLformat('%' . $_GET['nombre'] . '%');
        }

        if (isset($_GET['tipo'])) {
            $filters[] = "tipo_material.nombre LIKE " . self::SQLformat('%' . $_GET['tipo'] . '%');
        }

        $filters[] = "(materiales.borrado IS NULL OR materiales.borrado != 1)";

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
