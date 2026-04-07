<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CreateProductRequest;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\SharedBundle\ValueObject\Money;

final readonly class ProductManager implements ProductManagerInterface
{
    public function __construct(
        private ProductRepository $productRepository,
        private ProductPublisher $publisher,
    )
    {
    }

    public function create(CreateProductRequest $request): Product
    {
        $product = new Product(
            name: $request->name,
            price: Money::fromFloat($request->price, 'USD'),
            quantity: $request->quantity,
        );

        $this->productRepository->save($product);
        $this->publisher->publishCreated($product);

        return $product;
    }

    /**
     * @return Product[]
     */
    public function getAll(): array
    {
        return $this->productRepository->findAll();
    }

    public function getById(string $id): ?Product
    {
        return $this->productRepository->findOneByUuid($id);
    }
}