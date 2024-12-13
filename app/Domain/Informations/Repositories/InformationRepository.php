<?php

namespace App\Domain\Informations\Repositories;

use App\Domain\Informations\Models\Information;

class InformationRepository
{
    public function paginate($pagination,$filter)
    {
        return Information::query()
            ->Filter($filter)
            ->withTranslation()
            ->orderByTranslation('title')
            ->paginate($pagination);
    }
}
