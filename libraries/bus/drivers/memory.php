<?php namespace History\Bus\Drivers;

use Laravel\Event;
use Closure;

class Memory extends Driver {

	public function listeners()
	{
		$listeners = array();
		foreach (Event::$events as $listener => $handlers) {
			if(starts_with($listener, 'es'))
				$listeners[] = str_replace('es: ', '', $listener);
		}

		return $listeners;
	}

	/**
	 * Fire a event off to the listeners
	 *
	 * @param  string  $key
	 * @return void
	 */
	public function fire($channel, $arguments)
	{
		return Event::fire($channel, $arguments);
	}

	/**
	 * Add listener to channel
	 *
	 * @param  string   $channel
	 * @param  closure  $callback
	 * @return void
	 */
	public function listen($channel, Closure $callback)
	{
		Event::listen($channel, $callback);
	}

}