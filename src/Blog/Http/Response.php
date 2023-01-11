<?php

namespace Tgu\Savenko\Blog\Http;

abstract class Response
{
    protected const SUCCESS = true;


    public function send(): void
    {
        $data = ['success' => static::SUCCESS] + $this->payload();
        header('Content-Type:application/json');
        echo json_encode($data, JSON_THROW_ON_ERROR);
    }

    abstract function payload(): array;
}