<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function guests_may_not_create_threads()
	{
		$this->expectException('Illuminate\Auth\AuthenticationException');

		$thread = make('App\Thread');

		$this->post('http://localhost:8000/threads', $thread->toArray());
	}

	/** @test */
	public function an_authenticated_user_can_create_new_forum_threads()
	{
		$thread = make('App\Thread');

		$this->signIn();
		$this->post('http://localhost:8000/threads', $thread->toArray());

		$this->get('http://localhost:8000/threads/' . $thread->id)
			->assertSee($thread->title)
			->assertSee($thread->body);
	}
}
