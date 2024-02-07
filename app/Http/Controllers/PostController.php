<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function index(): JsonResponse
    {
        $posts = Post::query()
            ->limit(4)
            ->get()
        ;

        return response()
            ->json(new PostCollection($posts), Response::HTTP_OK);
    }

    public function store(StorePostRequest $request): JsonResponse
    {
        $post = Post::create($request->validated());

        return response()
            ->json(new PostResource($post), Response::HTTP_CREATED);
    }

    public function show(Post $post): JsonResponse
    {
        $post->load('category', 'comments', 'labels');

        return response()
            ->json(new PostResource($post), Response::HTTP_OK);
    }

    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        $post->update($request->validated());

        return response()
            ->json(new PostResource($post), Response::HTTP_OK);
    }

    public function destroy(Post $post): JsonResponse
    {
        try {
            $post->delete();
        } catch (\Throwable $t) {
            return response()
                ->json(['message' => $t->getMessage()], Response::HTTP_CONFLICT);
        }

        return response()
            ->json(null, Response::HTTP_NO_CONTENT);
    }
}
