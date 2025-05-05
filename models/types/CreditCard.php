<?php
class CreditCard
{
    private string $number;
    private string $expirationDate;
    private string $cvv;
    private string $holderName;

    public function __construct(
        string $number,
        string $expirationDate,
        string $cvv,
        string $holderName
    ) {
        $this->number = $number;
        $this->expirationDate = $expirationDate;
        $this->cvv = $cvv;
        $this->holderName = $holderName;
    }

    public static function empty(): self
    {
        return new self('', '', '', '');
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    public function getExpirationDate(): string
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(string $expirationDate): void
    {
        $this->expirationDate = $expirationDate;
    }

    public function getCvv(): string
    {
        return $this->cvv;
    }

    public function setCvv(string $cvv): void
    {
        $this->cvv = $cvv;
    }

    public function getHolderName(): string
    {
        return $this->holderName;
    }

    public function setHolderName(string $holderName): void
    {
        $this->holderName = $holderName;
    }

    public function __toString(): string
    {
        return "CreditCard [id={$this->id}, number={$this->number}, expirationDate={$this->expirationDate}, cvv={$this->cvv}, holderName={$this->holderName}]";
    }
}
