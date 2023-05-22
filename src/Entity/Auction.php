<?php

declare(strict_types=1);   
namespace App\Entity;

use App\Enum\AuctionStatus;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AuctionRepository;
use DateTime;
use DateTimeImmutable;
use Symfony\UX\Turbo\Attribute\Broadcast;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
#[HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: AuctionRepository::class)]
#[Broadcast]
class Auction implements TranslatableInterface
{
    use TranslatableTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $price = null;

   

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateOpen = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateClose = null;

    #[ORM\Column]
    
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255  , enumType:AuctionStatus::class)]
    private ?AuctionStatus $status = null;

    #[ORM\OneToMany(mappedBy: 'auction', targetEntity: Raise::class, orphanRemoval: true , cascade:['remove'])]
    private Collection $raises;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]

    private ?\DateTimeInterface $UpdatedAt = null;

    public function __construct()
    {
        $this->raises = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    
    public function setDescription():self
    {
        $this->translate()->description();
        return $this;
    }
    public function getDescription():string
    {
        return $this->translate()->getDescription();
        
    }
    public function setTitle():string
    {
        return $this->translate()->getTitle();
        
    }
    public function getTitle():string
    {
      return  $this->translate()->getTitle();
        
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

    public function getDateOpen(): ?\DateTimeInterface
    {
        return $this->dateOpen;
    }

    public function setDateOpen(\DateTimeInterface $dateOpen): self
    {
        $this->dateOpen = $dateOpen;

        return $this;
    }

    public function getDateClose(): ?\DateTimeInterface
    {
        return $this->dateClose;
    }

    public function setDateClose(\DateTimeInterface $dateClose): self
    {
        $this->dateClose = $dateClose;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }
    #[ORM\PrePersist]
    public function setCreatedAt(): self
    {
        $this->createdAt = new DateTimeImmutable();

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus(AuctionStatus $status): self
    {
      
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Raise>
     */
    public function getRaises(): Collection
    {
        return $this->raises;
    }

    public function addRaise(Raise $raise): self
    {
        if (!$this->raises->contains($raise)) {
            $this->raises->add($raise);
            $raise->setAuction($this);
        }

        return $this;
    }

    public function removeRaise(Raise $raise): self
    {
        if ($this->raises->removeElement($raise)) {
            // set the owning side to null (unless already changed)
            if ($raise->getAuction() === $this) {
                $raise->setAuction(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->UpdatedAt;
    }
    #[ORM\PreUpdate]
    public function setUpdatedAt(): self
    {
        $this->UpdatedAt = new DateTime();

        return $this;
    }
}