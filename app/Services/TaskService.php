<?php

namespace App\Services;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\TodoList;
use App\Models\Task;

class TaskService
{
    protected TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function createTask(TodoList $todoList, array $data): Task
    {
        return $this->taskRepository->create(array_merge($data, ['todo_id' => $todoList->id]));
    }

    public function updateTask(Task $task, array $data): Task
    {
        return $this->taskRepository->update($task, $data);
    }

    public function markTaskAsCompleted(Task $task): Task
    {
        if ($task->completed) {
            throw new \RuntimeException('Task is already marked as completed.');
        }

        return $this->taskRepository->markTaskAsCompleted($task);
    }

    public function markTaskAsUncompleted(Task $task): Task
    {
        if (!$task->completed) {
            throw new \RuntimeException('Task is not marked as completed.');
        }

        return $this->taskRepository->markTaskAsUncompleted($task);
    }

}
