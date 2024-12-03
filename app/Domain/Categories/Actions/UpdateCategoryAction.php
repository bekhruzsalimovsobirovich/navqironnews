<?php

namespace App\Domain\Categories\Actions;

use App\Domain\Categories\DTO\StoreCategoryDTO;
use App\Domain\Categories\DTO\UpdateCategoryDTO;
use App\Domain\Categories\Models\Category;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdateCategoryAction
{
    /**
     * @param UpdateCategoryDTO $dto
     * @return Category
     * @throws Exception
     */
    public function execute(UpdateCategoryDTO $dto): Category
    {
        DB::beginTransaction();
        try {
            $category = $dto->getCategory()->update([
                'parent_id' => $dto->getParentId(),
                'uz' => [
                    'name' => $dto->getUz()['name']
                ],
                'ru' => [
                    'name' => $dto->getRu()['name']
                ],
                'en' => [
                    'name' => $dto->getEn()['name']
                ]
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return $dto->getCategory();
    }
}
