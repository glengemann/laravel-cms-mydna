<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusCommentRequest;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    public function index(CommentRepository $repository): JsonResponse
    {
        $comments = $repository->findApproved();

        return response()
            ->json(new CommentCollection($comments), Response::HTTP_OK);
    }

    public function store(StoreCommentRequest $request): JsonResponse
    {
        $comment = Comment::create($request->validated());

        return response()
            ->json($comment, Response::HTTP_CREATED);
    }

    public function show(Comment $comment): JsonResponse
    {
        return response()
            ->json(new CommentResource($comment), Response::HTTP_OK);
    }

    public function update(UpdateCommentRequest $request, Comment $comment): JsonResponse
    {
        $comment->update($request->validated());

        return response()
            ->json(new CommentResource($comment), Response::HTTP_OK);
    }

    public function status(StatusCommentRequest $request, Comment $comment): JsonResponse
    {
        $comment->update($request->validated());

        return response()
            ->json(new CommentResource($comment), Response::HTTP_OK);
    }

    public function destroy(Comment $comment): JsonResponse
    {
        $comment->delete();

        return response()
            ->json(null, Response::HTTP_NO_CONTENT);
    }
}
