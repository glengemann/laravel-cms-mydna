<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Cache\CacheManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function __construct(readonly private CacheManager $cache)
    {
    }

    public function index(): JsonResponse
    {
        $categories = $this->cache
            ->remember('categories.index', 60, fn () => Category::orderBy('created_at', 'desc')->get());

        return response()
            ->json(new CategoryCollection($categories), Response::HTTP_OK);
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $this->authorize('store', Category::class);

        $category = Category::create($request->validated());

        $this->cache->forget('categories.index');

        return response()
            ->json(new CategoryResource($category), Response::HTTP_CREATED);
    }

    public function show(Category $category): JsonResponse
    {
        $category->load('posts');

        return response()
            ->json(new CategoryResource($category), Response::HTTP_OK);
    }

    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $this->authorize('update', $category);

        $category->update($request->validated());

        $this->cache->forget('categories.index');

        return response()
            ->json(new CategoryResource($category), Response::HTTP_OK);
    }

    public function destroy(Category $category): JsonResponse
    {
        $this->authorize('destroy', $category);

        try {
            $category->delete();
            $this->cache->forget('categories.index');
        } catch (\Exception $e) {
            return response()
                ->json(['message' => $e->getMessage()], Response::HTTP_CONFLICT);
        }

        return response()
            ->json(null, Response::HTTP_NO_CONTENT);
    }
}
