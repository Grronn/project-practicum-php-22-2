<?php

namespace Tgu\Savenko\PhpUnit\Blog\Http\Actions\Posts;

use PHPUnit\Framework\TestCase;
use Tgu\Savenko\Blog\Exceptions\PostNotFoundException;
use Tgu\Savenko\Blog\Http\Actions\Posts\CreatePosts;
use Tgu\Savenko\Blog\Http\ErrorResponse;
use Tgu\Savenko\Blog\Http\Request;
use Tgu\Savenko\Blog\Http\SuccessResponse;
use Tgu\Savenko\Blog\Post;
use Tgu\Savenko\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use Tgu\Savenko\Blog\UUID;

class CreatePostActionTest extends TestCase
{
    private function postRepository(array $posts): PostsRepositoryInterface
    {
        return new class($posts) implements PostsRepositoryInterface {

            public function __construct(
                public array $array
            )
            {
            }
            public function savePost(Post $post): void
            {
                // TODO: Implement savePost() method.
            }

            public function getByUuidPost(UUID $uuidPost): Post
            {
                throw new PostNotFoundException('Not found');
            }
        };
    }


    /**
     * @throws \JsonException
     */
    public function testItReturnErrorResponseIfNoUuid(): void
    {
        $request = new Request([], [], '');
        $postRepository = $this->postRepository([]);
        $action = new CreatePosts($postRepository);
        $response = $action->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->expectOutputString('{"success":false,"reason":"No such query param in the request uuid_post"}');
        $response->send();
    }


    /**
     * @throws \JsonException
     */
    public function testItReturnErrorResponseIfUUIDNotFound(): void{
        $uuid = UUID::random();
        $request = new Request(['uuid_post'=>$uuid], [], '');
        $userRepository = $this->postRepository([]);
        $action = new CreatePosts($userRepository);
        $response = $action->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->expectOutputString('{"success":false,"reason":"Not found"}');
        $response->send();
    }

    /**
     * @throws \JsonException
     */
    public function testItReturnSuccessfulResponse(): void{
        $uuid = UUID::random();
        $request = new Request(['uuid_post'=>"$uuid"], [],'');
        $postRepository = $this->postRepository([new Post($uuid,'cd6a4d34-3d65-44a5-bb52-90a0ce3efcb3','newTitle','textPost')]);
        $action = new CreatePosts($postRepository);
        $response = $action->handle($request);
        var_dump($response);
        $this->assertInstanceOf(SuccessResponse::class, $response);
        $this->expectOutputString('{"success":true,"data":{"uuid_post":"Ivan"}}');
        $response->send();
    }
}