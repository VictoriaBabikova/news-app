<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Address;
use App\Domain\ValueObject\Name;

class News
{
    private int $id;
    private string $created_at;

    public function __construct(
        private Name $name,
        private Address $address
    )
    {
        $this->created_at = date('Y-m-d');
    }

    public function getDate(): string
    {
        return $this->created_at;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): News
    {
        $this->address = $address;
        return $this;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function setName(Name $name): News
    {
        $this->name = $name;
        return $this;
    }
}
