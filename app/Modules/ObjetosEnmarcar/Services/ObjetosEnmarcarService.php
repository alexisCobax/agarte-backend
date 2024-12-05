<?php

namespace App\Modules\ObjetosEnmarcar\Services;

use App\Modules\ObjetosEnmarcar\Repositories\ObjetosEnmarcarRepository;

class ObjetosEnmarcarService
{
    public function create(): array { return ObjetosEnmarcarRepository::create(); }
    public function getAll(): array { return ObjetosEnmarcarRepository::find(); }
    public function get(): array { return ObjetosEnmarcarRepository::findById(); }
    public function update(): array { return ObjetosEnmarcarRepository::update(); }
    public function delete(): bool { return ObjetosEnmarcarRepository::delete(); }
}
