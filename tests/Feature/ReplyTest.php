<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Deverá listar as respostas de um tópico específico
     *
     * @return void
     */
    public function testRepliesListByThread()
    {
        $user = \App\Models\User::factory()->create();

        $this->seed('RepliesTableSeeder');

        $replies = \App\Models\Reply::where('thread_id', 2)
            ->get();
        
        $response = $this->actingAs($user)
            ->json('GET', '/replies/2');

        $response->assertStatus(200)
            ->assertJson($replies->toArray());
    }

    public function testAddNewReply()
    {
        $user = \App\Models\User::factory()->create();
        $thread = \App\Models\Thread::factory()->create();
        $response = $this
              ->actingAs($user)
              ->json('POST', '/replies', [
                'body' => "Esta é uma resposta do tópico!",
                'thread_id' => $thread->id
              ]);
        $reply = \App\Models\Reply::find(1);
        
        $response->assertStatus(200)
              ->assertJson($reply->toArray());
    }
}
