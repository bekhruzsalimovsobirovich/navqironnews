<?php

namespace App\Domain\Informations\DTO;

class StoreInformationDTO
{
    /**
     * @var int
     */
    private int $category_id;

    /**
     * @var string
     */
    private string $date;

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
     * @var array|null
     */
    private ?array $tags=null;

    /**
     * @param array $data
     * @return StoreInformationDTO
     */
    public static function fromArray(array $data): StoreInformationDTO
    {
        $dto = new self();
        $dto->setCategoryId($data['category_id']);
        $dto->setDate($data['date']);
        $dto->setUz($data['uz']);
        $dto->setRu($data['ru'] ?? null);
        $dto->setEn($data['en'] ?? null);
        $dto->setTags($data['tags'] ?? null);

        return $dto;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    /**
     * @param int $category_id
     */
    public function setCategoryId(int $category_id): void
    {
        $this->category_id = $category_id;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
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
     * @return array|null
     */
    public function getTags(): ?array
    {
        return $this->tags;
    }

    /**
     * @param array|null $tags
     */
    public function setTags(?array $tags): void
    {
        $this->tags = $tags;
    }
}
