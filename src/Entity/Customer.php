<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ORM\Table(name: 'customers')]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $gender = null;

    #[ORM\Column]
    private array $name = [];

    #[ORM\Column]
    private array $location = [];

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column]
    private array $login = [];

    #[ORM\Column]
    private array $dob = [];

    #[ORM\Column]
    private array $registered = [];

    #[ORM\Column(length: 20)]
    private ?string $phone = null;

    #[ORM\Column(length: 20)]
    private ?string $cell = null;

    #[ORM\Column]
    private array $identification = [];

    #[ORM\Column]
    private array $picture = [];

    #[ORM\Column(length: 20)]
    private ?string $nat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getName(): array
    {
        return $this->name;
    }

    public function getFullName(): string
    {
        $name = $this->getName();
        return $name['first'] . ' ' . $name['last'];
    }

    public function setName(array $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLocation(): array
    {
        return $this->location;
    }

    public function getCountry(): string
    {
        return $this->getLocation()['country'];
    }

    public function getCity(): string
    {
        return $this->getLocation()['city'];
    }

    public function setLocation(array $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getLogin(): array
    {
        return $this->login;
    }

    public function getUsername(): string
    {
        return $this->getLogin()['username'];
    }

    public function setLogin(array $login): static
    {
        $this->login = $login;

        return $this;
    }

    public function getDob(): array
    {
        return $this->dob;
    }

    public function setDob(array $dob): static
    {
        $this->dob = $dob;

        return $this;
    }

    public function getRegistered(): array
    {
        return $this->registered;
    }

    public function setRegistered(array $registered): static
    {
        $this->registered = $registered;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCell(): ?string
    {
        return $this->cell;
    }

    public function setCell(string $cell): static
    {
        $this->cell = $cell;

        return $this;
    }

    public function getIdentification(): array
    {
        return $this->identification;
    }

    public function setIdentification(array $identification): static
    {
        $this->identification = $identification;

        return $this;
    }

    public function getPicture(): array
    {
        return $this->picture;
    }

    public function setPicture(array $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getNat(): ?string
    {
        return $this->nat;
    }

    public function setNat(string $nat): static
    {
        $this->nat = $nat;

        return $this;
    }
}
