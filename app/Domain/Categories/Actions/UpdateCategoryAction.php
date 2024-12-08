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
            $dto->getCategory()->update([
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

            function handleFileCategory($fileData, $categoryId)
            {
                $filename = Str::random(6) . '_' . time() . '.' . $fileData['file']->getClientOriginalExtension();
                $fileData['file']->storeAs('public/files/categories', $filename);
                $path = url('storage/files/categories/' . $filename);

                return [
                    'filename' => $filename,
                    'path' => $path
                ];
            }

            foreach ($dto->getFiles() as $fileData) {
                if (isset($fileData['id'])) {
                    // Update existing file
                    $file = File::find($fileData['id']);
                    if ($file && $file->fileable_id == $dto->getCategory()->id) {
                        if (isset($fileData['file'])) {
                            \Illuminate\Support\Facades\File::delete('storage/files/categories/' . $file->filename);
                            $fileDetails = handleFileCategory($fileData, $dto->getCategory()->id);
                            $file->update($fileDetails);
                        }
                    }
                } else {
                    // Create a new file
                    $fileDetails = handleFileCategory($fileData, $dto->getCategory()->id);
                    $dto->getCategory()->files()->create($fileDetails);
                }
            }
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return $dto->getCategory();
    }
}
