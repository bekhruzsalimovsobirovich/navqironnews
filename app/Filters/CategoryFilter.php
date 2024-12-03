<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;

class CategoryFilter extends AbstractFilter
{
    public const NAME = 'name';

    /**
     * @return array[]
     */
    #[ArrayShape([self::NAME => "array"])] protected function getCallbacks(): array
    {
        return [
            self::NAME => [$this, 'name']
        ];
    }

    public function name(Builder $builder, $value): void
    {
        $builder->where('name', 'like', '%' . $value . '%');
    }
}
