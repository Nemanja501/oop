<?php
abstract class Soba{
    private int $brojSobe;
    private bool $privatnoKupatilo;
    private bool $imaBalkon;

    public function __construct(int $brojSobe, bool $privatnoKupatilo, bool $imaBalkon)
    {
        $this->brojSobe = $brojSobe;
        $this->privatnoKupatilo = $privatnoKupatilo;
        $this->imaBalkon = $imaBalkon;
    }
}

class JednokrevetnaSoba extends Soba{
    public function __construct(int $brojSobe, bool $privatnoKupatilo, bool $imaBalkon)
    {
        parent::__construct($brojSobe, $privatnoKupatilo, $imaBalkon);
    }
}

class DvokrevetnaSoba extends Soba{
    public function __construct(int $brojSobe, bool $privatnoKupatilo, bool $imaBalkon)
    {
        parent::__construct($brojSobe, $privatnoKupatilo, $imaBalkon);
    }
}

class TrokrevetnaSoba extends Soba{
    public function __construct(int $brojSobe, bool $privatnoKupatilo, bool $imaBalkon)
    {
        parent::__construct($brojSobe, $privatnoKupatilo, $imaBalkon);
    }
}

interface SobaFactory{
    public function createSoba(int $brojSobe, bool $privatnoKupatilo, bool $imaBalkon): Soba;
}

class JednokrevetnaSobaFactory implements SobaFactory{
    public function createSoba(int $brojSobe, bool $privatnoKupatilo, bool $imaBalkon): JednokrevetnaSoba
    {
        return new JednokrevetnaSoba($brojSobe, $privatnoKupatilo, $imaBalkon);
    }
}

class DvokrevetnaSobaFactory implements SobaFactory{
    public function createSoba(int $brojSobe, bool $privatnoKupatilo, bool $imaBalkon): DvokrevetnaSoba
    {
        return new DvokrevetnaSoba($brojSobe, $privatnoKupatilo, $imaBalkon);
    }
}

class TrokrevetnaSobaFactory implements SobaFactory{
    public function createSoba(int $brojSobe, bool $privatnoKupatilo, bool $imaBalkon): TrokrevetnaSoba
    {
        return new TrokrevetnaSoba($brojSobe, $privatnoKupatilo, $imaBalkon);
    }
}

$jednokrevetnaSobaFactory = new JednokrevetnaSobaFactory();
$jednokrevetnaSoba = $jednokrevetnaSobaFactory->createSoba(34, true, true);
var_dump($jednokrevetnaSoba);