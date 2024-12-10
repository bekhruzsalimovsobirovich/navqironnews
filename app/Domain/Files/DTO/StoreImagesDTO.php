<?php

namespace App\Domain\Files\DTO;

class StoreImagesDTO
{
    /**
     * @var array
     */
    private array $data;


    /**
     * @param array $data
     * @return StoreImagesDTO
     */
    public static function fromArray(array $data): StoreImagesDTO
    {
        $dto = new self();
        $dto->setData($data['data']);

        return $dto;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }
}
