<?php

namespace Tests\Feature;

use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testActionIndexOnController()
    {
        $user = \App\Models\User::factory()->create();
        $this->seed('ThreadsTableSeeder');

        $threads = Thread::orderBy("updated_at", 'desc')
            ->paginate();

        $response = $this
        ->actingAs($user)
        ->json('GET', '/threads');

        $response->assertStatus(200)
            ->assertJsonFragment([$threads->toArray()['data']]);
    }

    public function testActionStoreOnController()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->json('POST', '/threads', [
                'title' => 'Meu primeiro tópico', 
                'body' => 'Este é um exemplo de tópico'
            ]);
        
        $thread = Thread::find(1);

        $response->assertStatus(200)
            ->assertJsonFragment(['created' => 'success'])
            ->assertJsonFragment([$thread->toArray()]);
    }

    public function testActionUpdateOnController()
    {
        $user = \App\Models\User::factory()->create();
        $thread = \App\Models\Thread::factory()->create(
            [
                'user_id' => $user->id
            ]
        );


        $response = $this
            ->actingAs($user)
            ->json('PUT', '/threads/' .$thread->id, [
                'title' => 'Meu primeiro tópico atualizado', 
                'body' => 'Este é um exemplo de tópico atualizado'
            ]);
        
        $thread->title = 'Meu primeiro tópico atualizado';
        $thread->body = 'Este é um exemplo de tópico atualizado';

        $response->assertStatus(302);
        $this->assertEquals(Thread::find(1)->toArray(), $thread->toArray());
    }
}
