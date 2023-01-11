<?php



namespace Tgu\Savenko\Person;

use DateTimeImmutable;

class Person{
    public function __construct(private Name $name, private DateTimeImmutable $registredOn){

    }
    public function __toString():string{
        return $this->name.' на сайте с '.$this->registredOn->format('Y-m-d');
    }
}