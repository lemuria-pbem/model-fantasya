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
	/**
	 * @type array<string>
	 */
	private const array GROUPS = [
		'Building', 'Landscape', 'Race', 'Ship', 'Talent', 'Commodity', 'Spell',
		'Commodity\\Herb', 'Commodity\\Jewelry', 'Commodity\\Luxury', 'Commodity\\Monster', 'Commodity\\Potion',
		'Commodity\\Protection', 'Commodity\\Protection\\Repairable', 'Commodity\\Trophy',
		'Commodity\\Weapon', 'Commodity\\Weapon\\Repairable', 'Composition'
	];

	/**
	 * @return array<SingletonGroup>
	 */
	public function getGroups(): array {
		$groups = [];
		foreach (self::GROUPS as $group) {
			$groups[] = new SingletonGroup($group, __NAMESPACE__, __DIR__);
		}
		return $groups;
	}
}
