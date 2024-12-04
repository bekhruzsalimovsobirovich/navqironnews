<?php

namespace App\Domain\Informations\Actions;

use App\Domain\Informations\DTO\StoreInformationDTO;
use App\Domain\Informations\Models\Information;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

            if (!is_null($dto->getFiles())) {
                foreach ($dto->getFiles() as $file) {
                    $filename = Str::random(6) . '_' . time() . '.' . $file['file']->getClientOriginalExtension();
                    $file['file']->storeAs('public/files/informations/', $filename);
                    $path = url('storage/files/informations/' . $filename);
                    $information->files()->create([
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
        return $information;
    }
}
