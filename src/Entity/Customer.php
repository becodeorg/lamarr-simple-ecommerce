<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Customer implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Shoppingcart::class, mappedBy="customer", orphanRemoval=true)
     */
    private $cart;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="customer")
     */
    private $purchasedOrder;

    public function __construct()
    {
        $this->cart = new ArrayCollection();
        $this->purchasedOrder = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Shoppingcart[]
     */
    public function getCart(): Collection
    {
        return $this->cart;
    }

    public function addCart(Shoppingcart $cart): self
    {
        if (!$this->cart->contains($cart)) {
            $this->cart[] = $cart;
            $cart->setCustomer($this);
        }

        return $this;
    }

    public function removeCart(Shoppingcart $cart): self
    {
        if ($this->cart->removeElement($cart)) {
            // set the owning side to null (unless already changed)
            if ($cart->getCustomer() === $this) {
                $cart->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getPurchasedOrder(): Collection
    {
        return $this->purchasedOrder;
    }

    public function addPurchasedOrder(Order $purchasedOrder): self
    {
        if (!$this->purchasedOrder->contains($purchasedOrder)) {
            $this->purchasedOrder[] = $purchasedOrder;
            $purchasedOrder->setCustomer($this);
        }

        return $this;
    }

    public function removePurchasedOrder(Order $purchasedOrder): self
    {
        if ($this->purchasedOrder->removeElement($purchasedOrder)) {
            // set the owning side to null (unless already changed)
            if ($purchasedOrder->getCustomer() === $this) {
                $purchasedOrder->setCustomer(null);
            }
        }

        return $this;
    }

    public function getSingleCart() : Shoppingcart
    {
        if($this->cart[0]) {
            return $this->cart[0];
        } else {
            return new Shoppingcart($this);
        }
    }
}
