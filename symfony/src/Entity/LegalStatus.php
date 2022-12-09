<?php

namespace App\Entity;

use App\Repository\LegalStatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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


    #[ORM\OneToMany(mappedBy: 'legalStatus2', targetEntity: Company::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    #[Assert\Valid]

private Collection $company;

    public function __construct()
    {
        $this->company = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Company>
     */
    public function getCompany(): Collection
    {
        return $this->company;
    }

    public function addCompany(Company $company): self
    {
        if (!$this->company->contains($company)) {
            $this->company->add($company);
            $company->setLegalStatus($this);
        }

        return $this;
    }

    public function removeCompany(Company $company): self
    {
        if ($this->company->removeElement($company)) {
            // set the owning side to null (unless already changed)
            if ($company->getLegalStatus() === $this) {
                $company->setLegalStatus(null);
            }
        }

        return $this;
    }
}
