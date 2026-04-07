<?php

declare(strict_types=1);

namespace App\Entity;

use DomainException;
use InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use App\Repository\ProductRepository;
use App\SharedBundle\ValueObject\Money;
use App\SharedBundle\Doctrine\MappedSuperclass\AbstractProduct;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'products')]
class Product extends AbstractProduct
{
    public function __construct(
        string $name,
        Money $price,
        int $quantity,
    )
    {
        $this->id = Uuid::v4();
        $this->name = $name;
        $this->setPrice($price);
        $this->quantity = $quantity;
    }

    public function update(
        string $name,
        Money $price,
        int $quantity,
    ): void
    {
        $this->name = $name;
        $this->setPrice($price);
        $this->quantity = $quantity;
    }

    public function decreaseQuantity(int $quantity): void
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException('Quantity must be greater than zero.');
        }

        if ($this->quantity < $quantity) {
            throw new DomainException('Not enough product quantity available.');
        }

        $this->quantity -= $quantity;
    }
}