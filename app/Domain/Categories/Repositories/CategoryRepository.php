<?php

namespace App\Domain\Categories\Repositories;

use App\Domain\Categories\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    /**
     * @param $pagination
     * @return LengthAwarePaginator
     */
    public function paginate($pagination): LengthAwarePaginator
    {
        return Category::query()
            ->withTranslation()
            ->orderByTranslation('name')
            ->paginate($pagination);
    }

    /**
     * @return Builder[]|Collection
     */
    public function getAll(): Collection|array
    {
        return Category::query()
            ->get();
    }
}
