<?php

namespace App\Domain\Informations\Actions;

use App\Domain\Files\Models\File;
use App\Domain\Informations\DTO\UpdateInformationDTO;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UpdateInformationAction
{
    /**
     * @param UpdateInformationDTO $dto
     * @return mixed
     * @throws Exception
     */
    public function execute(UpdateInformationDTO $dto): mixed
    {
        DB::beginTransaction();
        try {
            $dto->getInformation()->update([
                'category_id' => $dto->getCategoryId(),
                'date' => $dto->getDate(),
                'uz' => [
                    'title' => $dto->getUz()['title'],
                    'text' => $dto->getUz()['text']
                ],
                'ru' => [
                    'title' => $dto->getRu()['title'] ?? null,
                    'text' => $dto->getRu()['text'] ?? null
                ],
                'en' => [
                    'title' => $dto->getEn()['title'] ?? null,
                    'text' => $dto->getRu()['text'] ?? null
                ]
            ]);

            function handleFile($fileData, $informationId)
            {
                $filename = Str::random(6) . '_' . time() . '.' . $fileData['file']->getClientOriginalExtension();
                $fileData['file']->storeAs('public/files/informations', $filename);
                $path = url('storage/files/informations/' . $filename);

                return [
                    'filename' => $filename,
                    'path' => $path
                ];
            }

            foreach ($dto->getFiles() as $fileData) {
                if (isset($fileData['id'])) {
                    // Update existing file
                    $file = File::find($fileData['id']);
                    if ($file && $file->fileable_id == $dto->getInformation()->id) {
                        if (isset($fileData['file'])) {
                            \Illuminate\Support\Facades\File::delete('storage/files/informations/' . $file->filename);
                            $fileDetails = handleFile($fileData, $dto->getInformation()->id);
                            $file->update($fileDetails);
                        }
                    }
                } else {
                    // Create a new file
                    $fileDetails = handleFile($fileData, $dto->getInformation()->id);
                    $dto->getInformation()->files()->create($fileDetails);
                }
            }
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return $dto->getInformation();
    }
}
