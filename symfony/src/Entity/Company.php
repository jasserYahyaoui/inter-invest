<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
private ?int $id = null;

    #[ORM\Column(length: 255)]
private ?string $name = null;

    #[ORM\Column(length: 255)]
private ?string $SIREN = null;

    #[ORM\Column(length: 255)]
private ?string $registrationCity = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
private ?\DateTimeInterface $registrationDate = null;

    #[ORM\Column]
private ?float $Capital = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Address::class, cascade: ['persist', 'remove'])]
    #[Assert\Valid]
private Collection $Address;

    #[ORM\ManyToOne(inversedBy: 'company2', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\Valid]
private ?LegalStatus $legalStatus = null;

    public function __construct()
    {
        $this->Address = new ArrayCollection();
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

    public function getSIREN(): ?string
    {
        return $this->SIREN;
    }

    public function setSIREN(string $SIREN): self
    {
        $this->SIREN = $SIREN;

        return $this;
    }

    public function getRegistrationCity(): ?string
    {
        return $this->registrationCity;
    }

    public function setRegistrationCity(string $registrationCity): self
    {
        $this->registrationCity = $registrationCity;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function getCapital(): ?float
    {
        return $this->Capital;
    }

    public function setCapital(float $Capital): self
    {
        $this->Capital = $Capital;

        return $this;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getAddress(): Collection
    {
        return $this->Address;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->Address->contains($address)) {
            $this->Address->add($address);
            $address->setCompany($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->Address->removeElement($address)) {
            if ($address->getCompany() === $this) {
                $address->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @param ArrayCollection $Address
     */
    public function setAddress($addressCollection)
    {
//        dd($addressCollection);
        if (!empty($addressCollection)) {
            foreach ($addressCollection as $address) {
                $this->addAddress($address);
            }
        }

        return $this;
    }

    public function getLegalStatus(): ?LegalStatus
    {
        return $this->legalStatus;
    }

    public function setLegalStatus(?LegalStatus $legalStatus): self
    {
        $this->legalStatus = $legalStatus;

        return $this;
    }

}
