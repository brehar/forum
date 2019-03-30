<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function a_user_can_view_all_threads()
	{
		$thread = factory('App\Thread')->create();
		$response = $this->get('http://localhost:8000/threads');

		$response->assertSee($thread->title);
	}

	/** @test */
	public function a_user_can_view_a_single_thread()
	{
		$thread = factory('App\Thread')->create();
		$response = $this->get('http://localhost:8000/threads/' . $thread->id);

		$response->assertSee($thread->title);
	}
}
