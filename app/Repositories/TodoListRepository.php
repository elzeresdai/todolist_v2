<?php

namespace App\Repositories;

use App\Interfaces\TodoListRepositoryInterface;
use App\Models\TodoList;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TodoListRepository implements TodoListRepositoryInterface
{

    public function getById(int $id): ?TodoList
    {
        return TodoList::find($id);
    }

    public function store(array $data): TodoList
    {
        return TodoList::create($data);
    }

    public function update(TodoList $todoList, array $data): TodoList
    {
        $todoList->update($data);
        return $todoList;
    }

    public function delete(TodoList $todoList): bool
    {
        return $todoList->delete();
    }

    public function getAllWithTasks(): LengthAwarePaginator
    {
        return TodoList::with('tasks')
            ->paginate(10);
    }

    public function makeCompleted(TodoList $todoList): bool
    {
        if($todoList->allTasksCompleted()){
            $todoList->update(['completed'=>true]);
        }

        return $todoList->completed;
    }


}
