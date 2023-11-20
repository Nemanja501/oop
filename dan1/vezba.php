<?php
class User{
    private string $name;
    private string $email;
    private string $password;

    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function setName(string $name): void{
        $this->name = $name;
    }

    public function setEmail(string $email): void{
        $this->email = $email;
    }

    public function setPassword(string $password): void{
        $this->password = $password;
    }

    public function getName(): string{
        return $this->name;
    }

    public function getEmail():string{
        return $this->email;
    }

    public function getPassword():string{
        return $this->password;
    }
}

$marko = new User('Marko', 'marko@marko', 'gutguoertg');
$pera = new User('Pera', 'pera@pera', 'rghruigergre');
$nemanja = new User('Nemanja', 'nemanja@nemanja', 'grihgirhg');

echo $marko->getName() . "\n";
echo $pera->getEmail() . "\n";
echo $nemanja->getPassword() . "\n";