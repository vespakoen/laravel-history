<?php namespace History;

use Laravel\Config;

class Bus {
	
	/**
	 * All of the active Bus drivers.
	 *
	 * @var array
	 */
	public static $drivers = array();

	/**
	 * Get the message driver instance.
	 *
	 * If no driver name is specified, the default will be returned.
	 *
	 * <code>
	 *		// Get the default message driver instance
	 *		$driver = Bus::driver();
	 *
	 *		// Get a specific Bus driver instance by name
	 *		$driver = Bus::driver('memcached');
	 * </code>
	 *
	 * @param  string        $driver
	 * @return Bus\Drivers\Driver
	 */
	public static function driver($driver = null)
	{
		if (is_null($driver)) $driver = Config::get('history::bus.driver');

		if ( ! isset(static::$drivers[$driver]))
		{
			static::$drivers[$driver] = static::factory($driver);
		}

		return static::$drivers[$driver];
	}

	/**
	 * Create a new message driver instance.
	 *
	 * @param  string  $driver
	 * @return Bus\Drivers\Driver
	 */
	protected static function factory($driver)
	{
		switch ($driver)
		{
			case 'memory':
				return new Bus\Drivers\Memory;

			default:
				throw new \Exception("Bus driver {$driver} is not supported.");
		}
	}

	/**
	 * Magic Method for calling the methods on the default Bus driver.
	 *
	 * <code>
	 *		// Call the "subscribe" method on the default Bus driver
	 *		Bus::subscribe('mychannel', function($message)
	 *		{
	 *			echo $message;
	 *		});
	 * </code>
	 */
	public static function __callStatic($method, $parameters)
	{
		return call_user_func_array(array(static::driver(), $method), $parameters);
	}

}