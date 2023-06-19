<?php

namespace App\Services;

use App\Exceptions\TodoListExceptions\TodoListNotEditableException;
use App\Exceptions\TodoListExceptions\TodoListNotFoundException;
use App\Exceptions\TodoListExceptions\TodoListServiceException;
use App\Interfaces\TodoListRepositoryInterface;
use App\Models\TodoList;
use App\Repositories\TodoListRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TodoListService
{
    protected TodoListRepositoryInterface $repository;

    public function __construct(TodoListRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): LengthAwarePaginator
    {
        return $this->repository->getAllWithTasks();
    }

    public function show(int $id): TodoList
    {
        $task = $this->repository->getById($id);

        if ($task === null) {
            throw new TodoListNotFoundException('TodoList not found');
        }

        return $task;
    }

    public function store(array $data): TodoList
    {
        return $this->repository->store($data);
    }

    public function update(int $id, array $data): TodoList
    {
        $todoList = $this->repository->getById($id);

        if (!$todoList) {
            throw new TodoListNotFoundException('TodoList not found');
        }

        if (!$todoList->isEditable()) {
            throw new TodoListNotEditableException('TodoList is not editable.');
        }

        return $this->repository->update($todoList, $data);
    }

    public function delete(int $id): bool
    {
        $todoList = $this->repository->getById($id);

        if (!$todoList) {
            throw new TodoListNotFoundException('TodoList not found');
        }

        return $this->repository->delete($todoList);
    }

    public function enableEditing(int $todoListId): void
    {
        try {
            $todoList = $this->repository->getById($todoListId);

            if ($todoList) {
                $this->repository->update($todoList, ['edit_option' => 'enabled']);
            } else {
                throw new TodoListNotFoundException('TodoList not found');
            }
        } catch (ModelNotFoundException $e) {
            throw new TodoListServiceException("Failed to enable editing: " . $e->getMessage());
        }
    }

    public function disableEditing(int $todoListId): void
    {
        try {
            $todoList = $this->repository->getById($todoListId);

            if ($todoList) {
                $this->repository->update($todoList, ['edit_option' => 'disabled']);
            } else {
                throw new TodoListNotFoundException('TodoList not found');
            }
        } catch (ModelNotFoundException $e) {
            throw new TodoListServiceException("Failed to disable editing: " . $e->getMessage());
        }
    }
}
