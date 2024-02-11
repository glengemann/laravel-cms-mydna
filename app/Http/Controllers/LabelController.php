<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLabelRequest;
use App\Http\Requests\UpdateLabelRequest;
use App\Http\Resources\LabelCollection;
use App\Http\Resources\LabelResource;
use App\Models\Label;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class LabelController extends Controller
{
    public function index(): JsonResponse
    {
        $labels = Label::all();

        return response()
            ->json(new LabelCollection($labels), Response::HTTP_OK);
    }

    public function store(StoreLabelRequest $request): JsonResponse
    {
        $this->authorize('store', Label::class);

        $label = Label::create($request->validated());

        return response()
            ->json(new LabelResource($label), Response::HTTP_CREATED);
    }

    public function show(Label $label): JsonResponse
    {
        return response()
            ->json(new LabelResource($label), Response::HTTP_OK);
    }

    public function update(UpdateLabelRequest $request, Label $label): JsonResponse
    {
        $this->authorize('update', $label);

        $label->update($request->validated());

        return response()
            ->json(new LabelResource($label), Response::HTTP_OK);
    }

    public function destroy(Label $label): JsonResponse
    {
        $this->authorize('destroy', $label);

        try {
            $label->delete();
        } catch (\Throwable $th) {
            return response()
                ->json(['message' => $th->getMessage()], Response::HTTP_CONFLICT);
        }

        return response()
            ->json(null, Response::HTTP_NO_CONTENT);
    }
}
