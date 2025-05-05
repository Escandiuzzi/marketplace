<?php
class Address
{
    private string $street;
    private string $number;
    private string $complement;
    private string $neighborhood;
    private string $city;
    private string $state;
    private string $zip;

    public function __construct(
        string $street,
        string $number,
        string $complement,
        string $neighborhood,
        string $city,
        string $state,
        string $zip
    ) {
        $this->street = $street;
        $this->number = $number;
        $this->complement = $complement;
        $this->neighborhood = $neighborhood;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
    }

    public function getStreet(): string
    {
        return $this->street;
    }
    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    public function getNumber(): string
    {
        return $this->number;
    }
    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    public function getComplement(): string
    {
        return $this->complement;
    }
    public function setComplement(string $complement): void
    {
        $this->complement = $complement;
    }

    public function getNeighborhood(): string
    {
        return $this->neighborhood;
    }
    public function setNeighborhood(string $neighborhood): void
    {
        $this->neighborhood = $neighborhood;
    }

    public function getCity(): string
    {
        return $this->city;
    }
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getState(): string
    {
        return $this->state;
    }
    public function setState(string $state): void
    {
        $this->state = $state;
    }

    public function getZip(): string
    {
        return $this->zip;
    }
    public function setZip(string $zip): void
    {
        $this->zip = $zip;
    }

    public function __toString(): string
    {
        return "Address: {$this->street}, {$this->number}, {$this->complement}, {$this->neighborhood}, {$this->city}, {$this->state}, {$this->zip}";
    }
}
