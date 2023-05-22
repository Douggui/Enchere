<?php

declare(strict_types=1);   
namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AuctionTranslatableRepository;
use Knp\DoctrineBehaviors\Model\Translatable\TranslationTrait;
use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;

#[ORM\Entity(repositoryClass: AuctionTranslatableRepository::class)]

class AuctionTranslation implements TranslationInterface
{
    use TranslationTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;
    public function getTitle(): ?string
    {
        return $this->title;
    }
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;
    

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
    
}