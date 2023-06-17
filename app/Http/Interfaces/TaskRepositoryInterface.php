<?php

namespace App\Http\Interfaces;

use App\Models\Task;

interface TaskRepositoryInterface
{
    public function getById(int $id): ?Task;

    public function create(array $data): Task;

    public function update(Task $task, array $data): Task;

    public function delete(Task $task): bool;
}
