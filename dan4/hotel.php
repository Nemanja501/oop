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

class Hotel{
    private static $instance;
    private $listaSoba = [
        JednokrevetnaSoba::class => [],
        DvokrevetnaSoba::class => [],
        TrokrevetnaSoba::class => []
    ];

    private $slobodneSobe = [
        JednokrevetnaSoba::class => 0,
        DvokrevetnaSoba::class => 0,
        TrokrevetnaSoba::class => 0
    ];

    private function __construct()
    {
        
    }

    static function getInstance(){
        if(self::$instance == null){
            self::$instance = new Hotel();
        }
        return self::$instance;
    }

    public function addSoba(Soba $soba){
        $tipSobe = get_class($soba);
        $this->listaSoba[$tipSobe][] = $soba;
        $this->slobodneSobe[$tipSobe]++;
    }

    public function iznajmiSobu(string $tipSobe){
        if($this->slobodneSobe[$tipSobe] > 0){
            echo "Iznajmljena " . $tipSobe . "\n";
            $this->slobodneSobe[$tipSobe]--;
            return $this->listaSoba[$tipSobe][array_rand($this->listaSoba[$tipSobe])];
        }else{
            echo "Nema slobodnih soba \n";
        }
    }

}

$jednokrevetnaSobaFactory = new JednokrevetnaSobaFactory();
$dvokrevetnaSobaFactory = new DvokrevetnaSobaFactory();
$jednokrevetnaSoba = $jednokrevetnaSobaFactory->createSoba();
$jednokrevetnaSoba->setBrojSobe(55);
$jednokrevetnaSoba->setPrivatnoKupatilo(true);
$jednokrevetnaSoba->setImaBalkon(false);
Hotel::getInstance()->addSoba($jednokrevetnaSoba);
$jednokrevetnaSoba2 = $jednokrevetnaSobaFactory->createSoba();
$jednokrevetnaSoba2->setBrojSobe(10);
$jednokrevetnaSoba2->setPrivatnoKupatilo(false);
$jednokrevetnaSoba2->setImaBalkon(false);
Hotel::getInstance()->addSoba($jednokrevetnaSoba2);
$dvokrevetnaSoba = $dvokrevetnaSobaFactory->createSoba();
$dvokrevetnaSoba->setBrojSobe(77);
$dvokrevetnaSoba->setPrivatnoKupatilo(true);
$dvokrevetnaSoba->setImaBalkon(true);
Hotel::getInstance()->addSoba($dvokrevetnaSoba);

$iznajmljenaSoba = Hotel::getInstance()->iznajmiSobu(DvokrevetnaSoba::class);
var_dump($iznajmljenaSoba);