<?php

namespace App\Domain\Informations\Actions;

use App\Domain\Informations\DTO\StoreInformationDTO;
use App\Domain\Informations\Models\Information;
use Exception;
use Illuminate\Support\Facades\DB;

class StoreInformationAction
{
    /**
     * @param StoreInformationDTO $dto
     * @return mixed
     * @throws Exception
     */
    public function execute(StoreInformationDTO $dto): mixed
    {
        DB::beginTransaction();
        try {
            $information = Information::create([
                'category_id' => $dto->getCategoryId(),
                'date' => $dto->getDate(),
                'files' => $dto->getFiles(),
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
                    'text' => $dto->getEn()['text'] ?? null
                ]
            ]);

            if ($dto->getTags()){
                foreach ($dto->getTags() as $tagName) {
                    $information->tags()->create([
                        'name' => $tagName['name'],
                    ]);
                }
            }
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return $information;
    }
}
