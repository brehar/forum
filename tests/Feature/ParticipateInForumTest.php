<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function unauthenticated_users_may_not_add_replies()
	{
		$this->expectException('Illuminate\Auth\AuthenticationException');

		$thread = factory('App\Thread')->create();
		$reply = factory('App\Reply')->make();

		$this->post('http://localhost:8000/threads/' . $thread->id . '/replies', $reply->toArray());
	}

	/** @test */
	public function an_authenticated_user_may_participate_in_forum_threads()
	{
		$thread = factory('App\Thread')->create();
		$reply = factory('App\Reply')->make();

		$this->signIn($user = factory('App\User')->create());
		$this->post('http://localhost:8000/threads/' . $thread->id . '/replies', $reply->toArray());
		$this->get('http://localhost:8000/threads/' . $thread->id)->assertSee($reply->body);
	}
}
