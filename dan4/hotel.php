<?php
abstract class Soba{
    private int $brojSobe;
    private bool $privatnoKupatilo;
    private bool $imaBalkon;

    public function __construct()
    {
    
    }

    public function setBrojSobe(int $brojSobe){
        $this->brojSobe = $brojSobe;
    }

    public function setPrivatnoKupatilo(bool $privatnoKupatilo){
        $this->privatnoKupatilo = $privatnoKupatilo;
    }

    public function setImaBalkon(bool $imaBalkon){
        $this->imaBalkon = $imaBalkon;
    }
}

class JednokrevetnaSoba extends Soba{

}

class DvokrevetnaSoba extends Soba{

}

class TrokrevetnaSoba extends Soba{

}

interface SobaFactory{
    public function createSoba(): Soba;
}

class JednokrevetnaSobaFactory implements SobaFactory{
    public function createSoba(): JednokrevetnaSoba
    {
        return new JednokrevetnaSoba();
    }
}

class DvokrevetnaSobaFactory implements SobaFactory{
    public function createSoba(): DvokrevetnaSoba
    {
        return new DvokrevetnaSoba();
    }
}

class TrokrevetnaSobaFactory implements SobaFactory{
    public function createSoba(): TrokrevetnaSoba
    {
        return new TrokrevetnaSoba();
    }
}

$jednokrevetnaSobaFactory = new JednokrevetnaSobaFactory();
$jednokrevetnaSoba = $jednokrevetnaSobaFactory->createSoba();
$jednokrevetnaSoba->setBrojSobe(55);
$jednokrevetnaSoba->setPrivatnoKupatilo(true);
$jednokrevetnaSoba->setImaBalkon(false);
var_dump($jednokrevetnaSoba);