<?php

namespace Tgu\Savenko\Blog\Http\Actions\Posts;

use Tgu\Savenko\Blog\Exceptions\HttpException;
use Tgu\Savenko\Blog\Exceptions\PostNotFoundException;
use Tgu\Savenko\Blog\Http\Actions\ActionInterface;
use Tgu\Savenko\Blog\Http\ErrorResponse;
use Tgu\Savenko\Blog\Http\Request;
use Tgu\Savenko\Blog\Http\Response;
use Tgu\Savenko\Blog\Http\SuccessResponse;
use Tgu\Savenko\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use Tgu\Savenko\Blog\UUID;

class CreatePosts implements ActionInterface
{

    public function __construct(
        private PostsRepositoryInterface $postsRepository
    )
    {
    }
    public function handle(Request $request): Response
    {
        try {
            $uuid = UUID::random();
            $id = $request->query('uuid');
            $post = $this->postsRepository->getByUuidPost($uuid);
        }
        catch (HttpException | PostNotFoundException $exception ){
            return new ErrorResponse($exception->getMessage());
        }
        $this->postsRepository->savePost($post);
        return new SuccessResponse(['uuid'=>$id, 'uuid_author'=>$post->getUuidAuthor(), 'title'=>$post->getTitlePost(), 'text'=>$post->getTextPost()]);
    }
}