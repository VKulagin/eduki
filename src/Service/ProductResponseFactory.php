<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;

final class ProductResponseFactory implements ProductResponseFactoryInterface
{
    public function one(Product $product): array
    {
        return [
            'id' => $product->getId()->toRfc4122(),
            'name' => $product->getName(),
            'price' => $product->getPrice()->asFloat(),
            'quantity' => $product->getQuantity(),
        ];
    }

    /**
     * @param Product[] $products
     */
    public function many(array $products): array
    {
        return [
            'data' => array_map(
                fn(Product $product) => $this->one($product),
                $products
            ),
        ];
    }
}