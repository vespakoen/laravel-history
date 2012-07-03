<?php namespace History\Bus\Drivers;

use History\EventConverter;

class Driver {

	/**
	 * Subscribe for an event
	 * @param  string   $channel  The event you want to subscribe to
	 * @param  Closure $callback The function that has to be called when the event arrives
	 * @return Void
	 */
	public function subscribe($channel, $callback)
	{
		$this->listen("history: {$channel}", $callback);
	}

	/**
	 * Publish an event to the subscribers
	 * @param  Event $event
	 * @return Void
	 */
	public function publish($events)
	{
		if( ! is_array($events)) $events = array($events);

		foreach ($events as $event)
		{
			if($converted_event = EventConverter::convert($event))
			{
				$this->publish($converted_event);
			}
			else
			{
				$identifier = get_class($event);
				$this->fire("history: {$identifier}", array($event));
			}
		}
	}

}