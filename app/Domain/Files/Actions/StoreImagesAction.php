<?php

namespace App\Domain\Files\Actions;

use App\Domain\Files\DTO\StoreImagesDTO;
use App\Domain\Files\Models\File;
use App\Domain\Images\Models\Image;
use Illuminate\Support\Str;
use function url;

class StoreImagesAction
{
    /**
     * @param StoreImagesDTO $dto
     * @return array
     */
    public function execute(StoreImagesDTO $dto): array
    {
        $data = array();
        for ($i = 0; $i < count($dto->getData()); $i++) {
            $files = new File();
            $file = $dto->getData()[$i]['file'];

            $filename = Str::random(6) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/files', $filename);
            $path = url('storage/files/' . $filename);

            $files->filename = $filename;
            $files->path = $path;
            $files->type = 'main';
            $files->save();
            $data[$i] = [
                'id' => $files->id,
                'path' => $path
            ];
        }

        return $data;
    }
}
