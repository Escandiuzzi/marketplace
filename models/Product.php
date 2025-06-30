<?php
class Product
{
    private int $id;
    private int $supplierId;
    private string $name;
    private string $description;
    private string $image;
    private Stock $stock;

    public function __construct(
        int $id,
        int $supplierId,
        string $name,
        string $description,
        ?string $image,
        Stock $stock
    ) {
        $this->id = $id;
        $this->supplierId = $supplierId;
        $this->name = $name;
        $this->description = $description;
        $this->image = $image ?? '';
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

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage($image): void
    {
        $this->image = $image;
    }

    public function __toString(): string
    {
        return "Product [name={$this->name}, description={$this->description}, stock={$this->stock}]";
    }
}
