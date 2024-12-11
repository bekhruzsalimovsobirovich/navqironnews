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
            $filename = null;
            if ($dto->getFile()) {
                $filename = Str::random(6) . '_' . time() . '.' . $dto->getFile()->getClientOriginalExtension();
                $dto->getFile()->storeAs('public/files/categories/', $filename);
            }

            $category = Category::create([
                'parent_id' => $dto->getParentId(),
                'file' => $filename,
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
