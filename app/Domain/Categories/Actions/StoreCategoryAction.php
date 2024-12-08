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
                    'name' => $dto->getUz()['name']
                ],
                'ru' => [
                    'name' => $dto->getRu()['name'] ?? null
                ],
                'en' => [
                    'name' => $dto->getEn()['name'] ?? null
                ]
            ]);

            if (!is_null($dto->getFiles())) {
                foreach ($dto->getFiles() as $file) {
                    $filename = Str::random(6) . '_' . time() . '.' . $file['file']->getClientOriginalExtension();
                    $file['file']->storeAs('public/files/categories/', $filename);
                    $path = url('storage/files/categories/' . $filename);
                    $category->files()->create([
                        'filename' => $filename,
                        'path' => $path,
                        'type' => $file['type'],    //main,top,right,bottom,left,center
                    ]);
                }
            }
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return $category;
    }
}
