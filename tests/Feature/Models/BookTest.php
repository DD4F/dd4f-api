<?php

namespace Tests\Feature\Models;

use Tests\TestCase;

class BookTest extends TestCase
{
    /*
    private $path = 'api/books';
    private $model = \App\Models\Book::class;
    private $table = 'books';

    public function testCreateBookTest()
    {
        $data = $this->model::factory()->make();

        $this->postJson($this->path, $data->toArray())
            ->assertCreated();

        $this->assertDatabaseHas($this->table, $data->toArray());
    }

    public function testShowBookTest()
    {
        $data = $this->model::factory()->create();

        $response = $this->getJson($this->path . '/' .  $data->getRouteKey());
        $response->assertOk();
        $response->assertJsonFragment($data->toArray());
    }

    public function testUpdateBookTest()
    {
        $data = $this->model::factory()->create();
        $newData = $this->model::factory()->make();

        $response = $this->putJson($this->path . '/' . $data->getRouteKey(), $newData->toArray());
        $response->assertNoContent();
    }

    public function testListBookTest()
    {
        $this->model::factory()->count(10)->create();

        $response = $this->get($this->path);
        $response->assertOk();
        $response->assertJsonCount(10, 'data');
    }

    public function testDeleteBookTest()
    {
        $data = $this->model::factory()->create();
        $this->delete($this->path . '/' . $data->getRouteKey())
            ->assertNoContent();

        $this->assertDatabaseCount($this->table, 1);
        $this->assertSoftDeleted($data);
    }
    */
}
