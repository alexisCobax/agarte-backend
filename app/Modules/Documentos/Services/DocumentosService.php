<?php

namespace App\Modules\Documentos\Services;

use PDOException;
use App\Modules\Documentos\Repositories\DocumentosRepository;

class DocumentosService
{
    public function create($request)
    {
    //--
    }

    public function getAll(): array
    {
        $items = DocumentosRepository::find();

        if (!$items) {
            throw new \Exception('No se encuentran documentos.');
        }
        return $items;
    }

    public function get($request)
    {
    //--
    }

    public function update($request)
    {
    //--
    }

    public function delete($request)
    {
    //--
    }
}