<?php

namespace Tgu\Savenko\Blog\Http\Actions\Posts;

use Tgu\Savenko\Blog\Exceptions\HttpException;
use Tgu\Savenko\Blog\Http\Actions\ActionInterface;
use Tgu\Savenko\Blog\Http\ErrorResponse;
use Tgu\Savenko\Blog\Http\Request;
use Tgu\Savenko\Blog\Http\Response;
use Tgu\Savenko\Blog\Http\SuccessResponse;
use Tgu\Savenko\Blog\Post;
use Tgu\Savenko\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use Tgu\Savenko\Blog\UUID;

class CreatePost implements ActionInterface
{
    public function __construct(
        private PostsRepositoryInterface $postsRepository
    )
    {

    }
    public function handle(Request $request): Response
    {
        try {
            $newPostUuid = UUID::random();
            $post = new Post($newPostUuid, $request->jsonBodyField('uuid_author'), $request->jsonBodyField('title'), $request->jsonBodyField('text'));
        }
        catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $this->postsRepository->savePost($post);
        return new SuccessResponse(['uuid'=>$newPostUuid]);
    }
}