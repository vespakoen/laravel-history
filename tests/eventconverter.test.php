<?php

use History\Bus;
use History\EventConverter;

class TestV1Event {

	public $data = 'V1 Event';

}

class TestV2Event {

	public $data;

}

class TestEventConverter extends PHPUnit_Framework_TestCase {

	public function setUp()
	{
		Bundle::start('history');
	}

	/**
	 * Test that a given condition is met.
	 *
	 * @return void
	 */
	public function testEventCanBeConverted()
	{
		Config::set('history::bus.driver', 'memory');

		$expected = false;

		EventConverter::register('TestV1Event', function($event)
		{
			$event = new TestV2Event;

			$event->data = 'V2 Event';

			return $event; 
		});

		Bus::subscribe('TestV2Event', function($event) use (&$expected)
		{
			$expected = $event->data == 'V2 Event';
		});

		Bus::publish(new TestV1Event);

		$this->assertTrue($expected);
	}

}