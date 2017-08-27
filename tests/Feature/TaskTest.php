<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Task;

class TaskTest extends TestCase
{
    /**
     *
     *
     * @return void
     */
    public function test_add_task_to_db()
    {
        $faker = \Faker\Factory::create();
        $task = new Task([
            'title' => $faker->sentence(),
            'description' => $faker->text(180),
            'due_date' => '2011-01-22 14:22:00',
            'completed' => false,
        ]);

        $response = $this->json('POST', '/api/tasks', $task->toArray());

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 'OK',
        ]);
    }

    public function test_show_task()
    {
        $lastInsertedId = Task::orderBy('created_at', 'desc')->first()->id;
        $response = $this->json('GET', '/api/tasks/' . $lastInsertedId);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                '_id',
                'title',
                'description',
                'due_date',
                'completed',
                'created_at',
                'updated_at'
            ]);
    }

    public function test_update_task()
    {
        $lastInsertedId = Task::orderBy('created_at', 'desc')->first()->id;
        $faker = \Faker\Factory::create();

        $response = $this->json(
            'PUT',
            '/api/tasks/' . $lastInsertedId,
            [
                'title' => $faker->sentence(),
                'description' => $faker->text(180),
                'due_date' => '2020-02-13 13:13:13',
                'completed' => false,
            ]
        );

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => "OK",
        ]);
    }

    public function test_delete_task()
    {
        $lastInsertedId = Task::orderBy('created_at', 'desc')->first()->id;
        $response = $this->json('DELETE', '/api/tasks/' . $lastInsertedId);
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 'OK',
            ]);
    }
}
