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
        $task = $this->taskRepository->create(array_merge($data, ['todo_id' => $todoList->id]));

        return $task;
    }

    public function updateTask(Task $task, array $data): Task
    {
        $task = $this->taskRepository->update($task, $data);

        return $task;
    }

    public function markTaskAsCompleted(Task $task): Task
    {
        if ($task->completed) {
            throw new \RuntimeException('Task is already marked as completed.');
        }

        $task = $this->taskRepository->markTaskAsCompleted($task);

        return $task;
    }

    public function markTaskAsUncompleted(Task $task): Task
    {
        if (!$task->completed) {
            throw new \RuntimeException('Task is not marked as completed.');
        }

        $task = $this->taskRepository->markTaskAsUncompleted($task);

        return $task;
    }

}
