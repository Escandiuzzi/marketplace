<?php
class Stock
{
    private int $quantity;
    private float $price;

    public function __construct(int $quantity, float $price)
    {
        $this->quantity = $quantity;
        $this->price = $price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
    
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
    
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function __toString(): string
    {
        return "Stock [quantity={$this->quantity}, price={$this->price}]";
    }
}
