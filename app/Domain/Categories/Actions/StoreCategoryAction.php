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

            if (!$dto->getFile() !== null) {
                $filename = Str::random(6) . '_' . time() . '.' . $dto->getFile()->getClientOriginalExtension();
                $dto->getFile()->storeAs('public/files/categories/', $filename);
                $path = url('storage/files/categories/' . $filename);
                $category->files()->create([
                    'filename' => $filename,
                    'path' => $path,
                    'type' => 'main',    //main,top,right,bottom,left,center
                ]);
            }
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return $category;
    }
}
