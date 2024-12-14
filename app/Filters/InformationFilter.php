<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;

class InformationFilter extends AbstractFilter
{
    public const TITLE = 'title';

    public const TAG = 'tag';

    public const SEARCH = 'search';

    /**
     * @return array[]
     */
    #[ArrayShape([self::TITLE => "array", self::TAG => "array", self::SEARCH => "array"])] protected function getCallbacks(): array
    {
        return [
            self::TITLE => [$this, 'title'],
            self::TAG => [$this, 'tag'],
            self::SEARCH => [$this, 'search'],
        ];
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
