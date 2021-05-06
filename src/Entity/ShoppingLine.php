<?php

namespace App\Entity;

use App\Repository\ShoppingLineRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShoppingLineRepository::class)
 */
class ShoppingLine
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Shoppingcart::class, inversedBy="shoppingLines")
     * @ORM\JoinColumn(nullable=false)
     */
    private $shoppingcart;

    public function __construct(Product $product, int $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function addQuantity(int $quantity)
    {
        $this->quantity += $quantity;

        return $this;
    }

    public function getPrice() : float
    {
        return $this->getProduct()->getPriceIncludingVat() * $this->quantity;
    }

    public function getShoppingcart(): ?Shoppingcart
    {
        return $this->shoppingcart;
    }

    public function setShoppingcart(?Shoppingcart $shoppingcart): self
    {
        $this->shoppingcart = $shoppingcart;

        return $this;
    }
}
