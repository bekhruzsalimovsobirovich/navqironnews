<?php

namespace App\Domain\Categories\Resources;

use App\Domain\Files\Resources\FileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class MainCategoryResource extends JsonResource
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
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'parent' => $this->parent,
            'children' => $this->children,
            'file' => url('storage/files/categories/' . $this->file)
        ];
    }
}
