<?php

namespace App\Entity;

use App\Repository\LegalStatusRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LegalStatusRepository::class)]
class LegalStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\OneToOne(mappedBy: 'legalStatus', cascade: ['persist', 'remove'])]
    private ?Company $company = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(Company $company): self
    {
        // set the owning side of the relation if necessary
        if ($company->getLegalStatus() !== $this) {
            $company->setLegalStatus($this);
        }

        $this->company = $company;

        return $this;
    }
}
