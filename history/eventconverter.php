<?php namespace History;

class EventConverter {

	public static $converters = array();

	public static function convert($event)
	{
		$identifier = get_class($event);

		if( ! array_key_exists($identifier, static::$converters))
		{
			return null;
		}

		return static::$converters[$identifier]($event);
	}

	public static function register($identifier, $callback)
	{
		static::$converters[$identifier] = $callback;
	}

}