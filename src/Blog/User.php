<?php

namespace Tgu\Savenko\Blog;

use Tgu\Savenko\Person\Name;

class User
{
    public function __construct(
        private UUID $uuid,
        private Name $name,
        private string $username,
    )
    {

    }
    public function __toString(): string
    {
        $uuid =$this->getUuid();
        $firstName = $this->name->getfirstName();
        $lastname = $this->name->getLastName();
        return "User $uuid с именем $firstName $lastname и логином $this->username" . PHP_EOL;
    }

    /**
     * @return UUID
     */
    public function getUuid(): UUID
    {
        return $this->uuid;
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }
}