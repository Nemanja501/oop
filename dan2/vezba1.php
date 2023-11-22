<?php
interface Pozajmica{
    function pozajmi();
    function vrati();
}

abstract class Artikal{
    private string $serijskiBroj;
    private string $proizvodjac;
    private string $model;
    private float $cena;
    private int $trenutnoStanje;

    public function __construct(string $serijskiBroj, string $proizvodjac, string $model, float $cena, int $trenutnoStanje)
    {
        $this->serijskiBroj = $serijskiBroj;
        $this->proizvodjac = $proizvodjac;
        $this->model = $model;
        $this->cena = $cena;
        $this->trenutnoStanje = $trenutnoStanje;
    }

    public function ispisiArtikal(){
        $imeArtikla = get_class($this);
        echo "Ime: " . $imeArtikla . ", serijski broj: " . $this->serijskiBroj . ", proizvodjac: " . $this->proizvodjac . ", model: " . $this->model . ", cena: " . $this->cena . ", trenutno stanje: " . $this->trenutnoStanje;
    }

    public function getPrice(){
        return $this->cena;
    }

    public function getCurrentStatus(){
        return $this->trenutnoStanje;
    }

    public function smanjiStanje(){
        $this->trenutnoStanje--;
    }

    public function povecajStanje(){
        $this->trenutnoStanje++;
    }
}

class RAM extends Artikal implements Pozajmica{
    private int $kapacitet;
    private float $frekvencija;

    public function __construct(string $serijskiBroj, string $proizvodjac, string $model, float $cena, int $trenutnoStanje, int $kapacitet, float $frekvencija)
    {
        parent::__construct($serijskiBroj, $proizvodjac, $model, $cena, $trenutnoStanje);
        $this->kapacitet = $kapacitet;
        $this->frekvencija = $frekvencija;
    }

    public function ispisiArtikal()
    {
        parent::ispisiArtikal();
        echo ", kapacitet: " . $this->kapacitet . ", frekvencija: " . $this->frekvencija . "\n";
    }

    public function pozajmi()
    {
        $this->smanjiStanje();
    }

    public function vrati()
    {
        $this->povecajStanje();
    }
}

class CPU extends Artikal{
    private int $brojJezgara;
    private float $frekvencija;

    public function __construct(string $serijskiBroj, string $proizvodjac, string $model, float $cena, int $trenutnoStanje, int $brojJezgara, float $frekvencija)
    {
        parent::__construct($serijskiBroj, $proizvodjac, $model, $cena, $trenutnoStanje);
        $this->brojJezgara = $brojJezgara;
        $this->frekvencija = $frekvencija;
    }

    public function ispisiArtikal()
    {
        parent::ispisiArtikal();
        echo ", broj jezgara: " . $this->brojJezgara . ", frekvencija: " . $this->frekvencija . "\n";
    }
}

class HDD extends Artikal{
    private int $kapacitet;

    public function __construct(string $serijskiBroj, string $proizvodjac, string $model, float $cena, int $trenutnoStanje, int $kapacitet)
    {
        parent::__construct($serijskiBroj, $proizvodjac, $model, $cena, $trenutnoStanje);
        $this->kapacitet = $kapacitet;
    }

    public function ispisiArtikal()
    {
        parent::ispisiArtikal();
        echo ", kapacitet: " . $this->kapacitet . "\n";
    }
}

class GPU extends Artikal{
    private float $frekvencija;

    public function __construct(string $serijskiBroj, string $proizvodjac, string $model, float $cena, int $trenutnoStanje, float $frekvencija)
    {
        parent::__construct($serijskiBroj, $proizvodjac, $model, $cena, $trenutnoStanje);
        $this->frekvencija = $frekvencija;
    }

    public function ispisiArtikal()
    {
        parent::ispisiArtikal();
        echo ", frekvencija: " . $this->frekvencija . "\n";
    }
}

class Prodavnica{
    private $listaArtikala = [];
    private $balans = 0;
    private $pozajmljeniArtikli = [];

    public function dodajArtikal(Artikal $artikal){
        $this->listaArtikala[] = $artikal;
    }

    public function ispisiSveArtikle(){
        foreach($this->listaArtikala as $artikal){
            $artikal->ispisiArtikal();
        }
    }

    public function prodajArtikal(Artikal $artikal){
        if($this->proveriDaLiJeArtikalUListi($artikal)){
            if($artikal->getCurrentStatus() > 0){
                $cena = $artikal->getPrice();
                $this->balans += $cena;
                $artikal->smanjiStanje();
                echo "Artikal prodat \n";
            }else{
                echo "Artikal nije na stanju \n";
            }
        }else{
            echo "Ne prodajemo ovaj artikal \n";
        }
    }

    public function proveriDaLiJeArtikalUListi(Artikal $artikal){
        foreach($this->listaArtikala as $trenutniArtikal){
            if($trenutniArtikal == $artikal){
                return true;
            }
        }
        return false;
    }

    public function getBalance(){
        return $this->balans;
    }

    public function pozajmiArtikal(Artikal $artikal){
        if($artikal->getCurrentStatus() <= 0){
            echo "Artikal nije na stanju \n";
        }
        else if($artikal instanceof Pozajmica && $this->proveriDaLiJeArtikalUListi($artikal)){
            $artikal->pozajmi();
            $this->balans += $artikal->getPrice() / 4;
            $this->pozajmljeniArtikli[] = $artikal;
            echo "Pozajmili smo vam ovaj artikal \n";
        }else{
            echo "Ne mozemo da pozajmimo ovaj artikal \n";
        }
    }

    public function vratiArtikal(Artikal $artikal){
        if($artikal instanceof Pozajmica && $this->proveriDaLiJeArtikalUListi($artikal)){
            $artikal->vrati();
            $this->balans -= $artikal->getPrice() / 4;
            echo "Vratili ste ovaj artikal \n";
        }else{
            echo "Ne mozete vratiti ovaj artikal \n";
        }
    }

}

$ram = new RAM('A7A', 'intel', 'cdsfvesfs', 500, 2, 8, 36.6);
$cpu = new CPU('6B6', 'intel', 'sadsadsa', 600, 1, 4, 32.5);
$hdd = new HDD('5H5', 'intel', 'dsadsadsa', 800, 2, 700);
$gpu = new GPU('1T1', 'nvidia', 'dsasadcdcdv', 500, 3, 35.5);
$prodavnica = new Prodavnica();
$prodavnica->dodajArtikal($ram);
$prodavnica->dodajArtikal($cpu);
$prodavnica->dodajArtikal($hdd);
$prodavnica->dodajArtikal($gpu);

$prodavnica->pozajmiArtikal($ram);
$prodavnica->pozajmiArtikal($ram);
$prodavnica->vratiArtikal($ram);
echo $prodavnica->getBalance();
echo "\n";