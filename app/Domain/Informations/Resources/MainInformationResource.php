<?php

namespace App\Domain\Informations\Resources;

use App\Domain\Categories\Resources\CategoryResource;
use App\Domain\Categories\Resources\MainCategoryResource;
use App\Domain\Files\Resources\FileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class MainInformationResource extends JsonResource
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
            'category' => new MainCategoryResource($this->category),
            'tags' => TagResource::collection($this->tags),
            'files' => $this->files,
        ];
    }
}
