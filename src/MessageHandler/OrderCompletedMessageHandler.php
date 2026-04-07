<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Repository\ProductRepository;
use App\SharedBundle\Message\OrderCompletedMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class OrderCompletedMessageHandler
{
    public function __construct(
        private ProductRepository $productRepository,
    ) {
    }

    public function __invoke(OrderCompletedMessage $message): void
    {
        $product = $this->productRepository->findOneByUuid($message->productId);

        if ($product === null) {
            throw new \DomainException('Product not found.');
        }

        if ($product->getQuantity() < $message->quantityOrdered) {
            throw new \DomainException('Not enough product quantity available.');
        }

        $product->decreaseQuantity($message->quantityOrdered);

        $this->productRepository->save($product);
    }
}