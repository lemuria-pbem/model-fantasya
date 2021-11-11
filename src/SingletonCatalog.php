<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Factory\SingletonCatalog as SingletonCatalogInterface;
use Lemuria\Factory\SingletonGroup;

/**
 * A map of Lemuria Singleton classes used for instantiation.
 */
class SingletonCatalog implements SingletonCatalogInterface
{
	private const GROUPS = [
		'Building', 'Landscape', 'Race', 'Ship', 'Talent', 'Commodity', 'Spell',
		'Commodity\\Herb', 'Commodity\\Luxury', 'Commodity\\Monster', 'Commodity\\Potion', 'Commodity\\Protection',
		'Commodity\\Trophy', 'Commodity\\Weapon'
	];

	/**
	 * @return SingletonGroup[]
	 */
	public function getGroups(): array {
		$groups = [];
		foreach (self::GROUPS as $group) {
			$groups[] = new SingletonGroup($group, __NAMESPACE__, __DIR__);
		}
		return $groups;
	}
}
