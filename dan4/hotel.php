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

interface HotelObserver {
    public function attach(Korisnik $korisnik, string $tipSobe);
    public function detach(Korisnik $korisnik, string $tipSobe);
    public function notify(string $tipSobe);
}

class Hotel implements HotelObserver{
    private static $instance;
    private $listaSoba = [];
    private $slobodneSobe = [
        JednokrevetnaSoba::class => 0,
        DvokrevetnaSoba::class => 0,
        TrokrevetnaSoba::class => 0
    ];
    private $subscriberi = [
        JednokrevetnaSoba::class => [],
        DvokrevetnaSoba::class => [],
        TrokrevetnaSoba::class => []
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

    public function iznajmiSobu(Korisnik $korisnik, string $tipSobe){
        if($this->slobodneSobe[$tipSobe] > 0){
            echo $korisnik->getIme() . " je iznajmio " . $tipSobe . "\n";
            $this->slobodneSobe[$tipSobe]--;
            return $this->listaSoba[$tipSobe][array_rand($this->listaSoba[$tipSobe])];
        }else{
            echo "Nema slobodnih soba. " . $korisnik->getIme() . " dodat na listu cekanja \n";
            $this->attach($korisnik, $tipSobe);
        }
    }

    public function checkout(Korisnik $korisnik, string $tipSobe){
        echo $korisnik->getIme() . " se checkoutovo \n";
        $this->slobodneSobe[$tipSobe]++;
        $this->detach($korisnik, $tipSobe);
        $this->notify($tipSobe);
    }

    public function attach(Korisnik $korisnik, string $tipSobe)
    {
        $this->subscriberi[$tipSobe][] = $korisnik;
    }

    public function detach(Korisnik $korisnik, string $tipSobe)
    {
        $key = array_search($korisnik, $this->subscriberi[$tipSobe]);
        unset($this->subscriberi[$tipSobe][$key]);
    }

    public function notify(string $tipSobe)
    {
        foreach($this->subscriberi[$tipSobe] as $subscriber){
            $subscriber->notify($tipSobe . " je dostupna");
        }
    }
}

class Korisnik{
    private string $ime;
    private string $prezime;
    private string $jmbg;
    
    public function __construct($ime, $prezime, $jmbg)
    {
        $this->ime = $ime;
        $this->prezime = $prezime;
        $this->jmbg = $jmbg;
    }

    public function getIme(){
        return $this->ime;
    }

    public function notify(string $message) {
        printf("%s: %s \n", $this->ime, $message);
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
$korisnik = new Korisnik('Pera', 'Tester', '23432532');
$korisnik2 = new Korisnik('Marko', 'Markovic', '5234234234');
$korisnik3 = new Korisnik('Mitar', 'Mitrovic', '432432423');

Hotel::getInstance()->iznajmiSobu($korisnik, DvokrevetnaSoba::class);
Hotel::getInstance()->iznajmiSobu($korisnik2, DvokrevetnaSoba::class);
Hotel::getInstance()->iznajmiSobu($korisnik3, DvokrevetnaSoba::class);
Hotel::getInstance()->checkout($korisnik, DvokrevetnaSoba::class);
Hotel::getInstance()->iznajmiSobu($korisnik2, DvokrevetnaSoba::class);
Hotel::getInstance()->checkout($korisnik2, DvokrevetnaSoba::class);