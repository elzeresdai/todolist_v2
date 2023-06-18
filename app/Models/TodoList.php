<?php

namespace App\Models;

use App\Exceptions\TodoListNotDeletableException;
use App\Exceptions\TodoListNotEditableException;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    use HasFactory;

    public const EDIT_OPTION_ENABLED = 'enabled';
    public const DELETE_OPTION_ENABLED = 'enabled';

    protected $table = 'to_do_lists';
    protected $fillable = [
        'name',
        'edit_options',
        'delete_options',
    ];

    /**
     * @throws Exception
     */
    public function delete(): ?bool
    {
        if (!$this->isDeletable()) {
            throw new TodoListNotDeletableException("TodoList is not deletable.");
        }

        return parent::delete();
    }


    public function isEditable(): bool
    {
        return $this->edit_options === self::EDIT_OPTION_ENABLED;

    }

    public function isDeletable(): bool
    {
        return $this->delete_options === self::DELETE_OPTION_ENABLED;
    }

    public function tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Task::class, 'todo_id', 'id');
    }

    public function allTasksCompleted(): bool
    {
        return $this->tasks()->where('completed', false)->doesntExist();
    }
}
