<?php

namespace Tests\Feature;

use App\Exceptions\TodoListExceptions\TodoListNotDeletableException;
use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testIndex(): void
    {
        TodoList::factory()->count(5)->create();

        $response = $this->getJson('/api/todolist');

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data');
    }

    public function testStore(): void
    {
        $payload = [
            'name' => $this->faker->word,
            'edit_option' => 'enabled',
            'delete_option' => 'enabled',
        ];

        $response = $this->postJson('/api/todolist', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'name' => $payload['name'],
                'edit_option' => $payload['edit_option'],
                'delete_option' => $payload['delete_option'],
            ]);
    }

    public function testShow(): void
    {
        $todoList = TodoList::factory()->create();

        $response = $this->getJson('/api/todolist/' . $todoList->id);

        $response->assertStatus(200)
            ->assertJson($todoList->toArray());
    }

    public function testUpdate(): void
    {
        $payload = [
            'name' => $this->faker->word,
            'edit_option' => 'enabled',
            'delete_option' => 'enabled',
        ];

        $this->withoutExceptionHandling();

        $todoList = TodoList::factory()->create($payload);

        $updatedPayload = [
            'name' => 'Updated TodoList',
        ];

        $response = $this->putJson('/api/todolist/' . $todoList->id, array_merge($payload, $updatedPayload));

        $response->assertStatus(200)
            ->assertJson($updatedPayload);

        $todoList->refresh();
        $this->assertEquals($updatedPayload['name'], $todoList->name);
    }

    public function testDestroyWithFail(): void
    {
        $this->withoutExceptionHandling();

        $payload = [
            'name' => $this->faker->word,
            'edit_option' => 'enabled',
            'delete_option' => 'disabled',
        ];

        $todoList = TodoList::factory()->create($payload);

        $this->expectException(TodoListNotDeletableException::class);
        $this->expectExceptionMessage('TodoList is not deletable.');

        $response = $this->delete('/api/todolist/' . $todoList->id);

        $response->assertStatus(400);
    }

    public function testEnableEditing(): void
    {
        $this->withoutExceptionHandling();

        $todoList = TodoList::factory()->create();

        $response = $this->patchJson('/api/todolist/' . $todoList->id . '/enable-editing');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Editing enabled successfully']);
    }

    public function testDisableEditing(): void
    {
        $this->withoutExceptionHandling();

        $todoList = TodoList::factory()->create();

        $response = $this->patchJson('/api/todolist/' . $todoList->id . '/disable-editing');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Editing disabled successfully']);
    }
}
