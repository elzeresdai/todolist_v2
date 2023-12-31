<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'todo_id',
        'task',
        'completed',
        'previously_completed',
        'disabled',
        'deadline'
    ];

    public function todoList(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TodoList::class, 'id', 'todo_id');
    }


}
