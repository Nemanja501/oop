<?php
interface Vehicle{
    public function inspect();
}

class Car implements Vehicle{
    public function inspect()
    {
        echo "Inspected car. \n";
    }
}

class Bike implements Vehicle{
    public function inspect()
    {
        echo "Inspected bike. \n";
    }
}

interface VehicleFactory{
    public function makeVehicle(): Vehicle;
}

class CarFactory implements VehicleFactory{
    public function makeVehicle(): Vehicle
    {
        return new Car();
    }
}

class BikeFactory implements VehicleFactory{
    public function makeVehicle(): Vehicle
    {
        return new Bike();
    }
}

class InspectionService{
    private static $instance;
    private int $counter;

    private function __construct()
    {
        $this->counter = 0;
    }

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new InspectionService();
        }
        return self::$instance;
    }

    public function inspectVehicle(Vehicle $vehicle){
        $vehicle->inspect();
        $this->counter++;
    }

    public function getCounter(){
        return $this->counter;
    }
}

$carFactory = new CarFactory();
$bikeFactory = new BikeFactory();
$car = $carFactory->makeVehicle();
$bike = $bikeFactory->makeVehicle();
InspectionService::getInstance()->inspectVehicle($car);
InspectionService::getInstance()->inspectVehicle($bike);
echo InspectionService::getInstance()->getCounter() . "\n";