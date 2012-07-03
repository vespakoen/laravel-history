<?php

use History\Bus;
use History\EventStore;
use History\UUID;

class StoredTestEvent {

	public $data = 'Hello World!';

	public $uuid;

	public function __construct()
	{
		$this->uuid = UUID::generate();
	}

}

class TestEventStore extends PHPUnit_Framework_TestCase {

	public function setUp()
	{
		Bundle::start('history');
	}

	/**
	 * Test that a given condition is met.
	 *
	 * @return void
	 */
	public function testEventCanBeStored()
	{
		Config::set('history::eventstore.driver', 'pdo');

		EventStore::save_events(array(new StoredTestEvent));

		$events = EventStore::all(0, 1);

		$event = json_decode($events[0]->event);

		$this->assertTrue($event->data == 'Hello World!');
	}

	public function tearDown()
	{
		DB::table('events')->delete();
	}

}