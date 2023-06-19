<?php

use App\Exceptions\TodoListExceptions\TodoListNotEditableException;
use App\Exceptions\TodoListExceptions\TodoListNotFoundException;
use App\Exceptions\TodoListExceptions\TodoListServiceException;
use App\Models\TodoList;
use App\Repositories\TodoListRepository;
use App\Services\TodoListService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class TodoListServiceTest extends TestCase
{
    protected TodoListRepository $repository;
    protected TodoListService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(TodoListRepository::class);
        $this->service = new TodoListService($this->repository);
    }

    public function testIndex(): void
    {
        $paginator = Mockery::mock(LengthAwarePaginator::class);
        $this->repository->shouldReceive('getAllWithTasks')->once()->andReturn($paginator);

        $result = $this->service->index();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }

    public function testShow(): void
    {
        $todoListId = 1;
        $todoList = Mockery::mock(TodoList::class);
        $this->repository->shouldReceive('getById')->with($todoListId)->once()->andReturn($todoList);

        $result = $this->service->show($todoListId);

        $this->assertSame($todoList, $result);
    }

    public function testShowNotFoundException(): void
    {
        $todoListId = 1;
        $this->repository->shouldReceive('getById')->with($todoListId)->once()->andReturnNull();

        $this->expectException(TodoListNotFoundException::class);

        $this->service->show($todoListId);
    }

    public function testStore(): void
    {
        $data = [
            'name' => 'Test TodoList',
            'edit_options' => 'enabled',
            'delete_options' => 'enabled',
        ];
        $this->repository->shouldReceive('store')->with($data)->once()->andReturn(Mockery::mock(TodoList::class));

        $result = $this->service->store($data);

        $this->assertInstanceOf(TodoList::class, $result);
    }


    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}

