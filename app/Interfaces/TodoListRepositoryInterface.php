<?php

namespace App\Interfaces;

use App\Models\TodoList;

interface TodoListRepositoryInterface
{
    public function getById(int $id): ?TodoList;

    public function store(array $data): TodoList;

    public function update(TodoList $todoList, array $data): TodoList;

    public function delete(TodoList $todoList): bool;

    public function getAllWithTasks();
}
