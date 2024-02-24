<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Model\Fantasya\Commodity\AbstractCommodity;
use Lemuria\Model\Fantasya\Commodity\Luxury\AbstractLuxury;
use Lemuria\Model\Fantasya\Commodity\Potion\AbstractPotion;
use Lemuria\Model\Fantasya\Commodity\Protection\AbstractProtection;
use Lemuria\Model\Fantasya\Commodity\Weapon\AbstractWeapon;
use Lemuria\Model\Fantasya\Commodity\Trophy\AbstractTrophy;
use Lemuria\Singleton;
use Lemuria\SingletonSet;
use Lemuria\SingletonTrait;

/**
 * This is a container placeholder for multiple commodities of the same kind.
 */
class Container implements Commodity
{
	use SingletonTrait;

	private readonly SingletonSet $commodities;

	private int $weight = 0;

	public static function isKindOf(Singleton $singleton, Kind $type): bool {
		return match($type) {
			Kind::Animal     => $singleton instanceof Animal,
			Kind::Herb       => $singleton instanceof Herb,
			Kind::Luxury     => $singleton instanceof Luxury,
			Kind::Material   => $singleton instanceof Material,
			Kind::Potion     => $singleton instanceof Potion,
			Kind::Shield     => $singleton instanceof Shield,
			Kind::Protection => $singleton instanceof Protection,
			Kind::Transport  => $singleton instanceof Transport,
			Kind::Trophy     => $singleton instanceof Trophy,
			Kind::Weapon     => $singleton instanceof Weapon
		};
	}

	public function __construct(private readonly Kind $type) {
		$this->commodities = new SingletonSet();
	}

	public function Weight(): int {
		return $this->weight;
	}

	public function Type(): Kind {
		return $this->type;
	}

	public function Commodities(): SingletonSet {
		return $this->commodities;
	}

	public function setResources(Resources $resources): static {
		$this->commodities->clear();
		$this->weight = 0;
		foreach ($resources as $quantity /* @var Quantity $quantity */) {
			$commodity = $quantity->getObject();
			if (self::isKindOf($commodity, $this->type)) {
				$this->commodities->add($commodity);
				$this->weight += $quantity->Weight();
			}
		}
		return $this;
	}

	public function fill(): static {
		switch ($this->type) {
			case Kind::Luxury :
				$this->commodities->fill(AbstractLuxury::all());
				break;
			case Kind::Potion :
				$this->commodities->fill(AbstractPotion::all());
				break;
			case Kind::Protection :
			case Kind::Shield :
				foreach (AbstractProtection::allWithRepairables() as $commodity) {
					if (self::isKindOf($commodity, $this->type)) {
						$this->commodities->add($commodity);
					}
				}
				break;
			case Kind::Trophy :
				$this->commodities->fill(AbstractTrophy::all());
				break;
			case Kind::Weapon :
				foreach (AbstractWeapon::allWithRepairables() as $commodity) {
					if (self::isKindOf($commodity, $this->type)) {
						$this->commodities->add($commodity);
					}
				}
				break;
			default :
				foreach (AbstractCommodity::all() as $commodity) {
					if (self::isKindOf($commodity, $this->type)) {
						$this->commodities->add($commodity);
					}
				}
				break;
		}
		return $this;
	}
}
