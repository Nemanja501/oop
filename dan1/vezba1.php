<?php
class BankAccount{
    public $currentBalance = 0;
    public bool $isBlocked = false;
    protected $lowerLimit = -200;
    protected $provizija = 0;

    public function checkIfAccountIsBlocked(){
        if($this->currentBalance <= $this->lowerLimit){
            $this->isBlocked = true;
            if($this->currentBalance >= 0){
                $this->isBlocked = false;
            }
        }
    }

    public function withdraw($amount){
        if($this->isBlocked == false){
            $this->currentBalance -= $amount + ($amount * ($this->provizija / 100));
            $this->checkIfAccountIsBlocked();
        }else{
            echo "Your account is blocked. \n";
        }
    }

    public function deposit($amount){
        $this->currentBalance += $amount - ($amount * ($this->provizija / 100));
        $this->checkIfAccountIsBlocked();
    }

    public function balance(){
        echo "Your current account balance is: " . $this->currentBalance . "\n";
    }

}

class SimpleBankAccount extends BankAccount{
}

class SecuredBankAccount extends BankAccount{
    protected $lowerLimit = -1000;
    protected $provizija = 2.5;
}

class User{
    public string $firstName;
    public string $lastName;
    public SimpleBankAccount $simpleAccount;
    public SecuredBankAccount $securedAccount;

    public function __construct($firstName, $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->simpleAccount = new SimpleBankAccount();
        $this->securedAccount = new SecuredBankAccount();
    }
}

$user = new User('Marko', 'Markovic');
$user->securedAccount->withdraw(200);
$user->securedAccount->balance();
$user->simpleAccount->withdraw(200);
$user->simpleAccount->balance();

$user->securedAccount->withdraw(100);
$user->simpleAccount->withdraw(100);

