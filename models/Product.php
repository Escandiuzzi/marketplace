<?php
class Product
{
    private int $id;
    private int $supplierId;
    private string $name;
    private string $description;
    private Stock $stock;

    public function __construct(
        int $id,
        int $supplierId,
        string $name,
        string $description,
        Stock $stock
    ) {
        $this->id = $id;
        $this->supplierId = $supplierId;
        $this->name = $name;
        $this->description = $description;
        $this->stock = $stock;
    }
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    
    public function getSupplierId(): int
    {
        return $this->supplierId;
    }
    
    public function setSupplierId(int $supplierId): void
    {
        $this->supplierId = $supplierId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    
    public function getDescription(): string
    {
        return $this->description;
    }
    
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
    
    public function getStock(): Stock
    {
        return $this->stock;
    }
    
    public function setStock(Stock $stock): void
    {
        $this->stock = $stock;
    }
    
    public function __toString(): string
    {
        return "Product [name={$this->name}, description={$this->description}, stock={$this->stock}]";
    }
}
