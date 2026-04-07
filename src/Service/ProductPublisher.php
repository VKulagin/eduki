<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;
use App\SharedBundle\DTO\ProductPayload;
use App\SharedBundle\Message\ProductCreatedMessage;
use App\SharedBundle\Message\ProductUpdatedMessage;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class ProductPublisher
{
    public function __construct(
        private MessageBusInterface $bus,
    )
    {
    }

    public function publishCreated(Product $product): void
    {
        $payload = new ProductPayload(
            id: $product->getId()->toRfc4122(),
            name: $product->getName(),
            price: $product->getPrice()->asFloat(),
            quantity: $product->getQuantity(),
        );

        $this->bus->dispatch(new ProductCreatedMessage($payload));
    }

    public function publishUpdated(Product $product): void
    {
        $payload = new ProductPayload(
            id: $product->getId()->toRfc4122(),
            name: $product->getName(),
            price: $product->getPrice()->asFloat(),
            quantity: $product->getQuantity(),
        );

        $this->bus->dispatch(new ProductUpdatedMessage($payload));
    }
}