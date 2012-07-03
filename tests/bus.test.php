<?php

use History\Bus;

class TestEvent {

	public $data = 'Hello World!';

}

class TestBus extends PHPUnit_Framework_TestCase {

	public function setUp()
	{
		Bundle::start('history');
	}

	/**
	 * Test that a given condition is met.
	 *
	 * @return void
	 */
	public function testEventCanBeSubscribedToAndCanBePublished()
	{
		Config::set('history::bus.driver', 'memory');

		$expected = false;

		Bus::subscribe('TestEvent', function($event) use (&$expected)
		{
			$expected = $event->data == 'Hello World!';
		});

		Bus::publish(new TestEvent);

		$this->assertTrue($expected);
	}

}