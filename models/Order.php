<?php

class Order
{
    private int $id;
    private int $clientId;
    private array $products;
    private int $total;
    private DateTime $createdAt;
    private ?DateTime $shippingDate;
    private Status $status;

    public function __construct(int $id, int $clientId, array $products, int $total, DateTime $createdAt, ?DateTime $shippingDate, Status $status)
    {
        $this->id = $id;
        $this->clientId = $clientId;
        $this->products = $products;
        $this->total = $total;
        $this->createdAt = $createdAt;
        $this->shippingDate = $shippingDate;
        $this->status = $status;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getClientId(): int
    {
        return $this->clientId;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getDisplayableTotal(): string
    {
        return number_format($this->total / 100, 2, ',', '.');
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setShippingDate(?DateTime $shippingDate): void
    {
        $this->shippingDate = $shippingDate;
    }

    public function getShippingDate(): ?DateTime
    {
        return $this->shippingDate;
    }

    public function setStatus(Status $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }
}
