<?php
class Student{
    private string $ime;
    private string $prezime;
    private int $brojIndeksa;

    public function __construct(string $ime, string $prezime, int $brojIndeksa)
    {
        $this->ime = $ime;
        $this->prezime = $prezime;
        $this->brojIndeksa = $brojIndeksa;
    }

    public function getIme(){
        return $this->ime;
    }

    public function getPrezime(){
        return $this->prezime;
    }

    public function getBrojIndeksa(){
        return $this->brojIndeksa;
    }
}

class Predmet{
    private string $naziv;
    private string $profesor;

    public function __construct(string $naziv, string $profesor)
    {
        $this->naziv = $naziv;
        $this->profesor = $profesor;
    }
}

class Ocena{
    private int $ocena;
    private string $datumOcenjivanja;
    private Student $student;
    private Predmet $predmet;

    public function __construct(int $ocena, string $datumOcenjivanja, Student $student, Predmet $predmet)
    {
        $this->ocena = $ocena;
        $this->datumOcenjivanja = $datumOcenjivanja;
        $this->student = $student;
        $this->predmet = $predmet;
    }
}

class StudentFactory{
    public function createStudent(string $ime, string $prezime, int $brojIndeksa){
        return new Student($ime, $prezime, $brojIndeksa);
    }
}

class PredmetFactory{
    public function createPredmet(string $naziv, string $profesor){
        return new Predmet($naziv, $profesor);
    }
}

class OcenaFactory{
    public function createOcena(int $ocena, string $datumOcenjivanja, Student $student, Predmet $predmet){
        return new Ocena($ocena, $datumOcenjivanja, $student, $predmet);
    }
}

class EvidencijaStudenata{
    private static $instance;
    private $studenti = [];

    private function __construct()
    {
        
    }

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new EvidencijaStudenata();
        }
        return self::$instance;
    }

    public function addStudent(Student $student){
        $this->studenti[] = $student;
    }

    public function getEveryStudentName(){
        foreach($this->studenti as $student){
            echo $student->getIme() . "\n";
        }
    }

    public function getEveryStudentLastName(){
        foreach($this->studenti as $student){
            echo $student->getPrezime() . "\n";
        }
    }

    public function getEveryStudentIndexNumber(){
        foreach($this->studenti as $student){
            echo $student->getBrojIndeksa() . "\n";
        }
    }
}

$studentFactory = new StudentFactory();
$student1 = $studentFactory->createStudent("Pera", "Tester", 34);
$student2 = $studentFactory->createStudent("Marko", "Markovic", 55);
EvidencijaStudenata::getInstance()->addStudent($student1);
EvidencijaStudenata::getInstance()->addStudent($student2);
EvidencijaStudenata::getInstance()->getEveryStudentIndexNumber();

$predmetFactory = new PredmetFactory();
$predmet = $predmetFactory->createPredmet("matematika", "Jovanov");
$ocenaFactory = new OcenaFactory();
$ocena = $ocenaFactory->createOcena(5, "03.05.2023", $student1, $predmet);

interface Ispit{

}

class PismeniIspit implements Ispit{
    private int $trajanje;

    public function setTrajanje($trajanje){
        $this->trajanje = $trajanje;
    }

    public function getTrajanje(){
        return $this->trajanje;
    }
}

class UsmeniIspit implements Ispit{
    private int $ocenaVerbalnogOdgovora;

    public function setOcena($ocenaVerbalnogOdgovora){
        $this->ocenaVerbalnogOdgovora = $ocenaVerbalnogOdgovora;
    }

    public function getOcena(){
        return $this->ocenaVerbalnogOdgovora;
    }
}

interface IspitFactory{
    public function createIspit(): Ispit;
}

class PismeniIspitFactory implements IspitFactory{
    public function createIspit(): PismeniIspit
    {
        return new PismeniIspit();
    }
}

class UsmeniIspitFactory implements IspitFactory{
    public function createIspit(): UsmeniIspit
    {
        return new UsmeniIspit();
    }
}

$usmeniIspitFactory = new UsmeniIspitFactory();
$usmeniIspit = $usmeniIspitFactory->createIspit();
$usmeniIspit->setOcena(5);
echo $usmeniIspit->getOcena() . "\n";

$pismeniIspitFactory = new PismeniIspitFactory();
$pismeniIspit = $pismeniIspitFactory->createIspit();
$pismeniIspit->setTrajanje(60);
echo $pismeniIspit->getTrajanje() . "\n";