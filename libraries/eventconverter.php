<?php namespace History;

class EventConverter {

	public static $converters = array();

	public static function convert($event)
	{
		$identifier = get_class($event);

		if( ! array_key_exists($identifier, static::$converters))
		{
			return false;
		}

		return call_user_func_array(static::$converters[$identifier], array($event));
	}

	public static function register($identifier, $callback)
	{
		static::$converters[$identifier] = $callback;
	}

}