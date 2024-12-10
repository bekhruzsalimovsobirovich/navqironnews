<?php

namespace App\Domain\Files\Actions;

use App\Domain\Files\DTO\UpdateImageDTO;
use Illuminate\Support\Str;
use function url;

class UpdateImagesAction
{
    /**
     * @param UpdateImageDTO $dto
     * @return array
     */
    public function execute(UpdateImageDTO $dto): array
    {
        $data = array();
        $files = $dto->getData();
        for ($i = 0; $i < count($files); $i++) {
            $file = new \App\Domain\Files\Models\File();

            $current_image = \App\Domain\Files\Models\File::find($files[$i]['id']);
            \Illuminate\Support\Facades\File::delete('storage/files/' . $current_image->filename);
            $current_image->delete();

            $filename = Str::random(6) . '_' . time() . '.' . $files[$i]['file']->getClientOriginalExtension();
            $files[$i]['file']->storeAs('public/files', $filename);
            $path = url('storage/files/' . $filename);

            $file->filename = $filename;
            $file->path = $path;
            $file->type = 'main';
            $file->save();
            $data[$i] = [
                'id' => $file->id,
                'path' => $path
            ];
        }

        return $data;
    }
}
