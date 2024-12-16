<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;

class InformationFilter extends AbstractFilter
{
    public const TITLE = 'title';

    public const CATEGORY_ID = 'category_id';

    public const TAG = 'tag';

    public const SEARCH = 'search';

    /**
     * @return array[]
     */
    #[ArrayShape([self::CATEGORY_ID => "array", self::TITLE => "array", self::TAG => "array", self::SEARCH => "array"])] protected function getCallbacks(): array
    {
        return [
            self::CATEGORY_ID => [$this, 'category_id'],
            self::TITLE => [$this, 'title'],
            self::TAG => [$this, 'tag'],
            self::SEARCH => [$this, 'search'],
        ];
    }

    public function category_id(Builder $builder, $value): void
    {
        $builder->where('category_id', $value);
    }

    public function title(Builder $builder, $value): void
    {
        $builder->where('title', 'like', '%' . $value . '%');
    }

    public function tag(Builder $builder, $value): void
    {
        $builder->whereHas('tags', function ($query) use ($value) {
            $query->where('name', 'like', '%' . $value . '%');
        });
    }

    public function search(Builder $builder, $value): void
    {
        $builder->where(function ($query) use ($value) {
            $query->where('title', 'like', '%' . $value . '%') // Title qidiruvi
            ->orWhereHas('tags', function ($tagQuery) use ($value) { // Tags orqali qidiruv
                $tagQuery->where('name', 'like', '%' . $value . '%');
            });
        });
    }
}
