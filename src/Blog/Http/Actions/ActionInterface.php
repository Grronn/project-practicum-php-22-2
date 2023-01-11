<?php

namespace Tgu\Savenko\Blog\Http\Actions;

use Tgu\Savenko\Blog\Http\Request;
use Tgu\Savenko\Blog\Http\Response;

interface ActionInterface
{
    public function handle(Request $request):Response;
}