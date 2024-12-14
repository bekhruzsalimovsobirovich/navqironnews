<?php

namespace App\Domain\Informations\Resources;

use App\Domain\Categories\Resources\CategoryResource;
use App\Domain\Files\Resources\FileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class InformationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'text' => $this->text,
            'date' => $this->date,
            'view_count' => $this->view_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'translations' => $this->getTranslationsArray(),
            'category' => new CategoryResource($this->category),
            'tags' => TagResource::collection($this->tags),
            'files' => $this->files,
        ];
    }
}
