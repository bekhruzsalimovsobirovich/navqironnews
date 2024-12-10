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
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return $dto->getInformation();
    }
}
