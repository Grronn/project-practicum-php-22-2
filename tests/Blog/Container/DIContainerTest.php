<?php

namespace Tgu\Savenko\PhpUnit\Blog\Container;

use PHPUnit\Framework\TestCase;
use Tgu\Savenko\Blog\Container\DIContainer;
use Tgu\Savenko\Blog\Exceptions\NotFoundException;
use Tgu\Savenko\Blog\Repositories\UsersRepository\InMemoryUsersRepository;
use Tgu\Savenko\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use Tgu\Savenko\Blog\User;

class DIContainerTest extends TestCase
{
    public function testItThrowAnExceptionIfCannotResolveType(): void
    {
        $container = new DIContainer();

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Cannot resolve type Tgu\Savenko\Blog\User');

        $container->get(User::class);
    }
    public function testItResolvesClassWithoutDependencies():void
    {
        $container = new DIContainer();
        $object = $container->get(SomeClassWithoutDependencies::class);
        $this->assertInstanceOf(SomeClassWithoutDependencies::class, $object);
    }
    public function testItResolvesClassByContract():void
    {
        $container = new DIContainer();
        $container->bind(UsersRepositoryInterface::class, InMemoryUsersRepository::class);
        $object = $container->get(UsersRepositoryInterface::class);
        $this->assertInstanceOf(InMemoryUsersRepository::class, $object);
    }
    public function testItReturnsPredefinedObject():void
    {
        $container = new DIContainer();
        $container->bind(SomeClassWithParameter::class, new SomeClassWithParameter(45));
        $object = $container->get(SomeClassWithParameter::class);
        $this->assertInstanceOf(SomeClassWithParameter::class, $object);
        $this->assertSame(45, $object->getValue());
    }
    public function testItResolvesClassWithDepencies():void
    {
        $container = new DIContainer();
        $container->bind(SomeClassWithParameter::class, new SomeClassWithParameter(45));
        $object = $container->get(SomeClassDependingOnAnother::class);
        $this->assertInstanceOf(SomeClassDependingOnAnother::class, $object);
    }
}