<?php namespace History;

use FilesystemIterator as fIterator;

class EventHandlers {

	public static $handlers = array();

	public static $allowed_events = array();

	public static function register($dirs)
	{
		if( ! is_array($dirs)) $dirs = array($dirs);

		foreach ($dirs as $dir)
		{
			foreach (static::files($dir, true) as $file)
			{
				static::$handlers[$file] = require_once $file;
			}
		}
	}

	public static function files($directory, $recursive = false, $options = fIterator::SKIP_DOTS)
	{
		$files = array();
		
		$items = new fIterator($directory, $options);

		foreach ($items as $item)
		{
			$full_path = $item->getPath().DS.$item->getFilename();
			if( ! $item->isDir())
			{
				if(ends_with($full_path, '.php'))
				{
					$files[] = $full_path;
				}
			}
			elseif($recursive)
			{
				$files = array_merge($files, static::files($full_path, true, $options));
			}
		}

		return $files;
	}

}
