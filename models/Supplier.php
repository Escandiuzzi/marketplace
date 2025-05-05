<?php

include_once('Identity.php');

class Supplier extends Identity
{
    private string $description;

    public function __construct(
        int $id,
        int $number,
        string $name,
        Address $address,
        string $description
    ) {
        parent::__construct($id, $number, $name, $address);
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function __toString()
    {
        return "Supplier: " . $this->getName() . ", Description: " . $this->description;
    }
}