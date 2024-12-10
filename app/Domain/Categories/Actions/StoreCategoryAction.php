<?php

namespace App\Domain\Categories\Actions;

use App\Domain\Categories\DTO\StoreCategoryDTO;
use App\Domain\Categories\Models\Category;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StoreCategoryAction
{
    public function execute(StoreCategoryDTO $dto): mixed
    {
        DB::beginTransaction();
        try {
            $category = Category::create([
                'parent_id' => $dto->getParentId(),
                'uz' => [
                    'name' => $dto->getUz()
                ],
                'ru' => [
                    'name' => $dto->getRu() ?? null
                ],
                'en' => [
                    'name' => $dto->getEn() ?? null
                ]
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return $category;
    }
}
