<?php
class BankAccount{
    public $currentBalance = 0;
    public bool $isBlocked = false;

    public function checkIfAccountIsBlocked(){
        if($this->currentBalance <= -200){
            $this->isBlocked = true;
            if($this->currentBalance >= 0){
                $this->isBlocked = false;
            }
        }
    }
}

class User{
    public string $firstName;
    public string $lastName;
    public BankAccount $account;

    public function __construct($firstName, $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->account = new BankAccount();
    }

    public function withdraw($amount){
        if($this->account->isBlocked == false){
            $this->account->currentBalance -= $amount;
            $this->account->checkIfAccountIsBlocked();
        }else{
            echo "Your account is blocked. \n";
        }
    }

    public function deposit($amount){
        $this->account->currentBalance += $amount;
        $this->account->checkIfAccountIsBlocked();
    }
}

$user = new User('Marko', 'Markovic');
$user->deposit(400);
echo $user->account->currentBalance . "\n";
$user->withdraw(700);
echo $user->account->currentBalance . "\n";
$user->withdraw(100);
$user->deposit(500);
echo $user->account->currentBalance . "\n";
