<?php

namespace App\Domain\Categories\DTO;

use App\Domain\Categories\Models\Category;
use Illuminate\Http\UploadedFile;

class UpdateCategoryDTO
{
    /**
     * @var int|null
     */
    private ?int $parent_id = null;

    /**
     * @var int|null
     */
    private ?int $file_id = null;

    /**
     * @var string
     */
    private string $uz;

    /**
     * @var string|null
     */
    private ?string $ru = null;

    /**
     * @var string|null
     */
    private ?string $en = null;

    /**
     * @var Category
     */
    private Category $category;

    /**
     * @var UploadedFile|null
     */
    private ?UploadedFile $file;

    /**
     * @param array $data
     * @return UpdateCategoryDTO
     */
    public static function fromArray(array $data): UpdateCategoryDTO
    {
        $dto = new self();
        $dto->setParentId($data['parent_id'] ?? null);
        $dto->setFileId($data['file_id'] ?? null);
        $dto->setUz($data['uz']);
        $dto->setRu($data['ru'] ?? null);
        $dto->setEn($data['en'] ?? null);
        $dto->setCategory($data['category']);
        $dto->setFile($data['file'] ?? null);

        return $dto;
    }

    /**
     * @return int|null
     */
    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    /**
     * @param int|null $parent_id
     */
    public function setParentId(?int $parent_id): void
    {
        $this->parent_id = $parent_id;
    }

    /**
     * @return string
     */
    public function getUz(): string
    {
        return $this->uz;
    }

    /**
     * @param string $uz
     */
    public function setUz(string $uz): void
    {
        $this->uz = $uz;
    }

    /**
     * @return string|null
     */
    public function getRu(): ?string
    {
        return $this->ru;
    }

    /**
     * @param string|null $ru
     */
    public function setRu(?string $ru): void
    {
        $this->ru = $ru;
    }

    /**
     * @return string|null
     */
    public function getEn(): ?string
    {
        return $this->en;
    }

    /**
     * @param string|null $en
     */
    public function setEn(?string $en): void
    {
        $this->en = $en;
    }

    /**
     * @return UploadedFile|null
     */
    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    /**
     * @param UploadedFile|null $file
     */
    public function setFile(?UploadedFile $file): void
    {
        $this->file = $file;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @return int|null
     */
    public function getFileId(): ?int
    {
        return $this->file_id;
    }

    /**
     * @param int|null $file_id
     */
    public function setFileId(?int $file_id): void
    {
        $this->file_id = $file_id;
    }
}
