<?php

namespace App\Http\Controllers;

use App\Exceptions\TodoListNotEditableException;
use App\Exceptions\TodoListNotFoundException;
use App\Exceptions\TodoListServiceException;
use App\Services\TodoListService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TodoListController extends Controller
{
    protected TodoListService $service;

    public function __construct(TodoListService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        try {
            $todoLists = $this->service->index();
            return response()->json($todoLists);
        } catch (TodoListServiceException $e) {
            return $this->handleException($e);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $task = $this->service->store($request->all());
            return response()->json($task, Response::HTTP_CREATED);
        } catch (TodoListServiceException $e) {
            return $this->handleException($e);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $task = $this->service->show($id);
            return response()->json($task);
        } catch (TodoListNotFoundException $e) {
            return $this->handleException($e, Response::HTTP_NOT_FOUND);
        } catch (TodoListServiceException $e) {
            return $this->handleException($e);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $task = $this->service->update($id, $request->all());
            return response()->json($task);
        } catch (TodoListNotFoundException $e) {
            return $this->handleException($e, Response::HTTP_NOT_FOUND);
        } catch (TodoListNotEditableException $e) {
            return $this->handleException($e, Response::HTTP_BAD_REQUEST);
        } catch (TodoListServiceException $e) {
            return $this->handleException($e);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->service->delete($id);
            return response()->json(['message' => 'TodoList deleted successfully']);
        } catch (TodoListNotFoundException $e) {
            return $this->handleException($e, Response::HTTP_NOT_FOUND);
        } catch (TodoListNotEditableException $e) {
            return $this->handleException($e, Response::HTTP_BAD_REQUEST);
        } catch (TodoListServiceException $e) {
            return $this->handleException($e);
        }
    }

    public function enableEditing(Request $request, int $id): JsonResponse
    {
        try {
            $this->service->enableEditing($id);
            return response()->json(['message' => 'Editing enabled successfully']);
        } catch (TodoListServiceException $e) {
            return $this->handleException($e);
        }
    }

    public function disableEditing(Request $request, int $id): JsonResponse
    {
        try {
            $this->service->disableEditing($id);
            return response()->json(['message' => 'Editing disabled successfully']);
        } catch (TodoListServiceException $e) {
            return $this->handleException($e);
        }
    }

    private function handleException(\Exception $e, int $statusCode = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json(['error' => $e->getMessage()], $statusCode);
    }
}
