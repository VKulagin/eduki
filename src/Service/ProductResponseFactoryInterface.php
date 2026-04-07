<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;

interface ProductResponseFactoryInterface
{
    public function one(Product $product): array;

    /**
     * @param Product[] $products
     */
    public function many(array $products): array;
}