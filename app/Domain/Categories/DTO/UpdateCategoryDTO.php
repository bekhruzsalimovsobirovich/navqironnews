<?php

namespace App\Domain\Categories\DTO;

use App\Domain\Categories\Models\Category;

class UpdateCategoryDTO
{
    /**
     * @var int|null
     */
    private ?int $parent_id = null;

    /**
     * @var array
     */
    private array $uz;

    /**
     * @var array|null
     */
    private ?array $ru = null;

    /**
     * @var array|null
     */
    private ?array $en = null;

    /**
     * @var Category
     */
    private Category $category;

    /**
     * @var array|null
     */
    private ?array $files = null;

    /**
     * @param array $data
     * @return UpdateCategoryDTO
     */
    public static function fromArray(array $data): UpdateCategoryDTO
    {
        $dto = new self();
        $dto->setParentId($data['parent_id'] ?? null);
        $dto->setUz($data['uz']);
        $dto->setRu($data['ru'] ?? null);
        $dto->setEn($data['en'] ?? null);
        $dto->setCategory($data['category']);
        $dto->setFiles($data['files'] ?? null);

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
     * @return array
     */
    public function getUz(): array
    {
        return $this->uz;
    }

    /**
     * @param array $uz
     */
    public function setUz(array $uz): void
    {
        $this->uz = $uz;
    }

    /**
     * @return array|null
     */
    public function getRu(): ?array
    {
        return $this->ru;
    }

    /**
     * @param array|null $ru
     */
    public function setRu(?array $ru): void
    {
        $this->ru = $ru;
    }

    /**
     * @return array|null
     */
    public function getEn(): ?array
    {
        return $this->en;
    }

    /**
     * @param array|null $en
     */
    public function setEn(?array $en): void
    {
        $this->en = $en;
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
     * @return array|null
     */
    public function getFiles(): ?array
    {
        return $this->files;
    }

    /**
     * @param array|null $files
     */
    public function setFiles(?array $files): void
    {
        $this->files = $files;
    }
}
