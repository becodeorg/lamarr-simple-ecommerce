<?php

namespace App\Entity;

use App\Repository\ShoppingcartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShoppingcartRepository::class)
 */
class Shoppingcart
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name = 'Active shoppingcart';

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="cart")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @ORM\OneToMany(targetEntity=ShoppingLine::class, mappedBy="shoppingcart", orphanRemoval=true,cascade={"persist"})
     */
    private $shoppingLines;

    public function __construct(Customer $customer)
    {
        $this->shoppingLines = new ArrayCollection();
        $this->customer = $customer;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Collection|ShoppingLine[]
     */
    public function getShoppingLines(): Collection
    {
        return $this->shoppingLines;
    }

    public function addShoppingLine(ShoppingLine $shoppingLine): self
    {
        if (!$this->shoppingLines->contains($shoppingLine)) {
            foreach($this->getShoppingLines() AS $existingLine) {
                if($existingLine->getProduct()->getId() === $shoppingLine->getProduct()->getId()) {
                    $existingLine->addQuantity($shoppingLine->getQuantity());
                    return $this;
                }
            }
            $this->shoppingLines[] = $shoppingLine;
            $shoppingLine->setShoppingcart($this);
        }

        return $this;
    }

    public function removeShoppingLine(ShoppingLine $shoppingLine): self
    {
        if ($this->shoppingLines->removeElement($shoppingLine)) {
            // set the owning side to null (unless already changed)
            if ($shoppingLine->getShoppingcart() === $this) {
                $shoppingLine->setShoppingcart(null);
            }
        }

        return $this;
    }

    public function getTotalprice() : float
    {
        $total = 0;
        foreach($this->getShoppingLines() AS $line) {
            $total += $line->getPrice();
        }
        return $total;
    }
}
