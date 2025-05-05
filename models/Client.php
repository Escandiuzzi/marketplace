<?php

include_once('Identity.php');
include_once('Authenticable.php');
include_once('types/Address.php');
include_once('types/CreditCard.php');

class Client extends Identity
{
    use Authenticable;

    private CreditCard $creditCard;

    public function __construct(
        int $id,
        int $number,
        string $email,
        string $password,
        string $name,
        Address $address,
        CreditCard $creditCard
    ) {
        parent::__construct($id, $number, $name, $address);
        $this->creditCard = $creditCard;
        
        $this->setEmail($email);
        $this->setPassword($password);
    }
    
    public function getCreditCard(): CreditCard
    {
        return $this->creditCard;
    }
    
    public function setCreditCard(CreditCard $creditCard): void
    {
        $this->creditCard = $creditCard;
    }

    public function __toString()
    {
        return "Client: " . $this->getName() . ", Email: " . $this->getEmail() . ", Credit Card: " . $this->creditCard->getNumber();
    }
}
