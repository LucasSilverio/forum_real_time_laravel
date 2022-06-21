<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Thread;

class RepliesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $threads = \App\Models\Thread::factory()->count(50)->create();
        $threads->each(function($thread){
            \App\Models\Reply::factory()->count(rand(5,10))->create(['thread_id' => $thread->id]);
        });
    }
}
