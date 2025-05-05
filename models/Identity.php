<?php
abstract class Identity
{
    private int $id;
    private int $number;
    private string $name;
    private Address $address;

    public function __construct($id, $number, $name, $address)
    {
        $this->id = $id;
        $this->number = $number;
        $this->name = $name;
        $this->address = $address;
    }

    public function getId(): int
    {
        return $this->id;
    }
    
    public function setId($id): void
    {
        $this->id = $id;
    }
    
    public function getNumber(): int
    {
        return $this->number;
    }

    public function setNumber($number): void
    {
        $this->number = $number;
    }

    public function getName(): string
    {
        return $this->name;
    }
    
    public function setName($name): void
    {
        $this->name = $name;
    }
    
    public function getAddress(): Address
    {
        return $this->address;
    }
    
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    public function __toString()
    {
        return "User: " . $this->getName() . ", Number: " . $this->getNumber();
    }
}
