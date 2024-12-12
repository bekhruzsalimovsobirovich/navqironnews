<?php

namespace App\Domain\Categories\Actions;

use App\Domain\Categories\DTO\StoreCategoryDTO;
use App\Domain\Categories\DTO\UpdateCategoryDTO;
use App\Domain\Categories\Models\Category;
use App\Domain\Files\Models\File;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use function App\Domain\Informations\Actions\handleFile;

class   UpdateCategoryAction
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
            $filename = null;
            if ($dto->getFile()) {
                \Illuminate\Support\Facades\File::delete('storage/files/categories/' . $dto->getCategory()->file);
                $filename = Str::random(6) . '_' . time() . '.' . $dto->getFile()->getClientOriginalExtension();
                $dto->getFile()->storeAs('public/files/categories/', $filename);
            }

            $dto->getCategory()->update([
                'parent_id' => $dto->getParentId(),
                'file' => $filename ?? $dto->getCategory()->file,
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
        return $dto->getCategory();
    }
}
