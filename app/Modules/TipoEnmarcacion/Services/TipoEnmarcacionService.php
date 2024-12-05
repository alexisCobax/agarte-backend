<?php

namespace App\Modules\TipoEnmarcacion\Services;

use App\Modules\TipoEnmarcacion\Repositories\TipoEnmarcacionRepository;

class TipoEnmarcacionService
{
    public function create(): array { return TipoEnmarcacionRepository::create(); }
    public function getAll(): array { return TipoEnmarcacionRepository::find(); }
    public function get(): array { return TipoEnmarcacionRepository::findById(); }
    public function update(): array { return TipoEnmarcacionRepository::update(); }
    public function delete(): bool { return TipoEnmarcacionRepository::delete(); }
}
