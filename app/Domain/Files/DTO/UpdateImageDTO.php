<?php

namespace App\Domain\Files\DTO;

use App\Domain\Files\Models\File;

class UpdateImageDTO
{
    /**
     * @var array
     */
    private array $data;


    /**
     * @param array $data
     * @return UpdateImageDTO
     */
    public static function fromArray(array $data): UpdateImageDTO
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
