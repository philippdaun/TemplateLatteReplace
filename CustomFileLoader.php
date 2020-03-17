<?php namespace ProcessWire;

use Latte\Loaders\FileLoader;

/**
 * Custom template file loader.
 *
 * Modified to allow including files from basedir directly by prepending ~ or /
 * Example:
 *   /partials/image.latte >> /path/to/view/dir/partials/image.latte
 *   ~partials/image.latte >> /path/to/view/dir/partials/image.latte
 */
class CustomFileLoader extends FileLoader
{
	/**
	 * Aliases that refer to the base dir when prepended to a filename
	 *
	 * @var array
	 */
	static protected $baseDirAliases = [
		'/',
		'~',
	];

	/**
	 * Returns referred template name.
	 *
	 * Check for prepended alias to baseDir and return path from there if found
	 * Otherwise, refer to default implementation
	 *
	 */
	public function getReferredName($file, $referringFile): string
	{
		if (
			$this->baseDir &&
			in_array(substr($file, 0, 1), static::$baseDirAliases)
		) {
			return $this->normalizePath(substr($file, 1));
		}
		return parent::getReferredName($file, $referringFile);
	}
}
