<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Repository\RaiseRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RaiseRepository::class)]
#[Assert\Expression( "(this.getPrice() - this.getAuction().getPrice() ) >= 500 " ,message:'vous devez rajouter minimum 5€ au prix initial',) ]
class Raise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    // #[Assert\GreaterThan(500 , message:'votre enchère doit être supérieur à 5€')]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'raises')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Auction $auction = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getAuction(): ?Auction
    {
        return $this->auction;
    }

    public function setAuction(?Auction $auction): self
    {
        $this->auction = $auction;

        return $this;
    }
}