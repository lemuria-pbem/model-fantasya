<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Factory;

use function Lemuria\hasPrefix;
use Lemuria\Exception\LemuriaException;
use Lemuria\Exception\SingletonException;

/**
 * A map of Lemuria Singleton classes used for instantiation.
 */
class SingletonMap
{
	/**
	 * @var string[]
	 */
	private static array $groups = ['Building', 'Landscape', 'Race', 'Ship', 'Talent', 'Commodity', 'Commodity/Luxury',
		                           'Commodity/Weapon'];

	private static string $groupDir;

	/**
	 * @var array(string=>int)
	 */
	private static array $map = [];

	/**
	 * @throws LemuriaException
	 */
	public function __construct() {
		self::$groupDir = realpath(__DIR__ . '/..');
		foreach (self::$groups as $groupId => $group) {
			foreach ($this->getGroupFiles($group) as $path) {
				$file = basename($path);
				if (hasPrefix('Abstract', $file)) {
					continue;
				}
				$class             = substr($file, 0, strlen($file) - 4);
				self::$map[$class] = $groupId;
			}
			self::$groups[$groupId] = str_replace('/', '\\', $group);
		}
	}

	/**
	 * Get the full namespaced class name of a Singleton class.
	 *
	 * @param string $class
	 * @return string
	 * @throws SingletonException
	 */
	public function find(string $class): string {
		if (!isset(self::$map[$class])) {
			throw new SingletonException($class);
		}
		$groupId = self::$map[$class];
		$group   = self::$groups[$groupId];
		return 'Lemuria\\Model\\Lemuria\\' . $group . '\\' . $class;
	}

	/**
	 * Get all files of a Singleton group.
	 *
	 * @param string $group
	 * @return array(string)
	 * @throws LemuriaException
	 */
	private function getGroupFiles(string $group): array {
		$groupDir = self::$groupDir . '/' . $group;
		if (!is_dir($groupDir)) {
			// @codeCoverageIgnoreStart
			throw new LemuriaException('Singleton group ' . $group . ' not found.');
			// @codeCoverageIgnoreEnd
		}
		return glob($groupDir . '/*.php');
	}
}
