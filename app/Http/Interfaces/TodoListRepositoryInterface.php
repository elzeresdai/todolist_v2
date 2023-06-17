<?php

namespace App\Http\Interfaces;

use App\Models\TodoList;

interface TodoListRepositoryInterface
{
    public function getById(int $id): ?TodoList;

    public function create(array $data): TodoList;

    public function update(TodoList $todoList, array $data): TodoList;

    public function delete(TodoList $todoList): bool;

    public function getAllWithTasks();
}
