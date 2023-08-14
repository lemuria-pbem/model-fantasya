<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use function Lemuria\getClass;
use Lemuria\Item;
use Lemuria\ItemSet;
use Lemuria\Model\Fantasya\Commodity\Herb\AbstractHerb;
use Lemuria\Model\Fantasya\Commodity\Luxury\AbstractLuxury;
use Lemuria\Model\Fantasya\Commodity\Potion\AbstractPotion;
use Lemuria\Model\Fantasya\Commodity\Protection\AbstractProtection;
use Lemuria\Model\Fantasya\Commodity\Trophy\AbstractTrophy;
use Lemuria\Model\Fantasya\Commodity\Weapon\AbstractWeapon;
use Lemuria\Model\Fantasya\Commodity\Weapon\Repairable\AbstractRepairable as AbstractRepairableWeapon;
use Lemuria\Model\Fantasya\Commodity\Protection\Repairable\AbstractRepairable as AbstractRepairableProtection;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Singleton;
use Lemuria\SingletonSet;

/**
 * Resources are sets of quantities.
 *
 * @method Quantity offsetGet(Singleton|string $offset)
 * @method Quantity current()
 */
class Resources extends ItemSet
{
	use BuilderTrait;

	private static ?array $all = null;

	public static function getAll(): array {
		if (!self::$all) {
			self::$all = [];
			self::addSingletons(Commodity::MISC);
			self::addSingletons(AbstractLuxury::all());
			self::addSingletons(AbstractWeapon::all());
			self::addSingletons(AbstractProtection::all());
			self::addSingletons(AbstractRepairableWeapon::all());
			self::addSingletons(AbstractRepairableProtection::all());
			self::addSingletons(AbstractHerb::all());
			self::addSingletons(AbstractPotion::all());
			self::addSingletons(AbstractTrophy::all());
		}
		return self::$all;
	}

	public function getClone(): static {
		return clone $this;
	}

	public function add(Quantity $quantity): static {
		$this->addItem($quantity);
		return $this;
	}

	public function remove(Quantity $quantity): static {
		$this->removeItem($quantity);
		return $this;
	}

	/**
	 * Create an Item from unserialized data.
	 */
	protected function createItem(string $class, int $count): Item {
		return new Quantity(self::createCommodity($class), $count);
	}

	/**
	 * Check if an item is valid for this set.
	 */
	protected function isValidItem(Item $item): bool {
		return $item instanceof Quantity;
	}

	private static function addSingletons(SingletonSet|array $set): void {
		foreach ($set as $class) {
			self::$all[] = getClass($class);
		}
	}
}
