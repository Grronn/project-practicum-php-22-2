<?php

namespace Tgu\Savenko\Person;

class Name{
    public function __construct(
        public int $id,
        private string $firstName,
        private string $lastName)
    {

    }
    public function __toString(): string{
        return 'ID пользователя: '.$this->id . ' Имя: ' . $this->firstName . ' Фамилия: ' . $this->lastName;
    }
}