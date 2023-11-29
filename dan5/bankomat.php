<?php
abstract class State{
    public function insertCardAndPin(string $card, string $pin){

    }

    public function inputAmountAndConfirm(float $amount){

    }

    public function demandCheck(){

    }
}

class ReadyState extends State{
    public function insertCardAndPin(string $card, string $pin)
    {
        echo "Successfully inserted card and pin \n";
        return true;
    }

    public function inputAmountAndConfirm(float $amount)
    {
        echo "Cannot input amount in this state \n";
        return false;
    }

    public function demandCheck()
    {
        echo "Cannot demant check in this state \n";
        return false;
    }
}

class ValidatedState extends State{
    public function insertCardAndPin(string $card, string $pin)
    {
        echo "Cannot insert card and pin in this state \n";
        return false;
    }

    public function inputAmountAndConfirm(float $amount)
    {
        echo "Successfully inputed amount \n";
        return true;
    }

    public function demandCheck()
    {
        echo "Cannot demand check in this state \n";
        return false;
    }
}

class PaidState extends State{
    public function insertCardAndPin(string $card, string $pin)
    {
        echo "Cannot insert card and pin in this state \n";
        return false;
    }

    public function inputAmountAndConfirm(float $amount)
    {
        echo "Cannot input amount in this state \n";
        return false;
    }

    public function demandCheck()
    {
        echo "Here's your check \n";
        return true;
    }
}

class Bankomat{
    private $state;

    public function __construct()
    {
        $this->state = new ReadyState();
    }

    public function insertCardAndPin(string $card, string $pin){
        if($this->state->insertCardAndPin($card, $pin)){
            $this->state = new ValidatedState();
        }
    }

    public function inputAmountAndConfirm(float $amount){
        if($this->state->inputAmountAndConfirm($amount)){
            $this->state = new PaidState();
        }
    }

    public function demandCheck(){
        if($this->state->demandCheck()){
            $this->state = new ReadyState();
        }
    }
}

$bankomat = new Bankomat();
$bankomat->inputAmountAndConfirm('432423');
$bankomat->insertCardAndPin('432121', '21321');
$bankomat->demandCheck();
$bankomat->inputAmountAndConfirm('432423');
$bankomat->demandCheck();