<?php

namespace Tgu\Savenko\Blog\Http\Actions\Comments;

use Tgu\Savenko\Blog\Comment;
use Tgu\Savenko\Blog\Exceptions\HttpException;
use Tgu\Savenko\Blog\Http\Actions\ActionInterface;
use Tgu\Savenko\Blog\Http\ErrorResponse;
use Tgu\Savenko\Blog\Http\Request;
use Tgu\Savenko\Blog\Http\Response;
use Tgu\Savenko\Blog\Http\SuccessResponse;
use Tgu\Savenko\Blog\Repositories\CommentsRepository\CommentsRepositoryInterface;
use Tgu\Savenko\Blog\UUID;

class CreateComment implements ActionInterface
{
    public function __construct(
        private CommentsRepositoryInterface $commentsRepository
    )
    {

    }

    public function handle(Request $request): Response
    {
        try {
            $newCommentUuid = UUID::random();
            $comment = new Comment($newCommentUuid, $request->jsonBodyField('uuid_post'), $request->jsonBodyField('uuid_author'), $request->jsonBodyField('textCom'));
        }
        catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $this->commentsRepository->saveComment($comment);
        return new SuccessResponse(['uuid'=>(string)$newCommentUuid]);
    }
}