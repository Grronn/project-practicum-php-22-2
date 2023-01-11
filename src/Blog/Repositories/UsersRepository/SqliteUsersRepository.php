<?php

namespace Tgu\Savenko\Blog\Repositories\UsersRepository;

use PDO;
use Tgu\Savenko\Blog\User;

class SqliteUsersRepository
{
    public function __construct(private PDO $connection)
    {

    }

    public function save(User $user): void{
        $statement=$this->connection->prepare(
            "INSERT INTO users (first_name, last_name) VALUES (:first_name,:last_name)"
        );

        $statement->execute([
            ':first_name'=>$user->getFirstName(),
            ':last_name'=>$user->getLastName(),
        ]);
    }
}