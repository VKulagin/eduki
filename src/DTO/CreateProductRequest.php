<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateProductRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public string $name;

    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    public float $price;

    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    public int $quantity;

    public static function fromArray(array $data): self
    {
        $dto = new self();
        $dto->name = (string)($data['name'] ?? '');
        $dto->price = (float)($data['price'] ?? 0);
        $dto->quantity = (int)($data['quantity'] ?? 0);

        return $dto;
    }
}