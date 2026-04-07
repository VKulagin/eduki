<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CreateProductRequest;
use App\Entity\Product;

interface ProductManagerInterface
{
    public function create(CreateProductRequest $request): Product;

    /**
     * @return Product[]
     */
    public function getAll(): array;

    public function getById(string $id): ?Product;
}