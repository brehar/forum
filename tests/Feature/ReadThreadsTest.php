<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
	use DatabaseMigrations;

	public function setUp()
	{
		parent::setUp();

		$this->thread = create('App\Thread');
	}

	/** @test */
	public function a_user_can_view_all_threads()
	{
		$this->get('http://localhost:8000/threads')->assertSee($this->thread->title);
	}

	/** @test */
	public function a_user_can_view_a_single_thread()
	{
		$this->get('http://localhost:8000/threads/' . $this->thread->id)->assertSee($this->thread->title);
	}

	/** @test */
	public function a_user_can_read_replies_that_are_associated_with_a_thread()
	{
		$reply = create('App\Reply', ['thread_id' => $this->thread->id]);

		$this->get('http://localhost:8000/threads/' . $this->thread->id)->assertSee($reply->body);
	}
}
