<?php

namespace Tgu\Savenko\Person;

class Name{
    public function __construct(

        private string $firstName,
        private string $lastName)
    {

    }
    public function __toString(): string{
        return $this->firstName . ' ' . $this->lastName;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }
}