<?php

include_once('Authenticable.php');

class Administrator 
{
    use Authenticable;
    
    private string $name;
    private int $id;

    public function __construct(
        int $id,
        string $name,
        string $email,
        string $password,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->setEmail($email);
        $this->setPassword($password);
    }

    public function getId(): int
    {
        return $this->id;
    }
    
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    
    public function getEmail(): string
    {
        return $this->email;
    }
    
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    
    public function getPassword(): string
    {
        return $this->password;
    }
    
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function __toString(): string
    {
        return "id: " . $this->id . "\n" .
            "name: " . $this->name . "\n" .
            "email: " . $this->email . "\n" .
            "password: " . $this->password . "\n";
    }
}