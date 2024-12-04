<?php

namespace App\Domain\Informations\Repositories;

use App\Domain\Informations\Models\Information;

class InformationRepository
{
    public function paginate($pagination)
    {
        return Information::query()
            ->withTranslation()
            ->orderByTranslation('title')
            ->paginate($pagination);
    }
}
