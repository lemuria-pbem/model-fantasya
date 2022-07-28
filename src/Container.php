<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

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
			Kind::Potion     => $singleton instanceof Potion,
			Kind::Shield     => $singleton instanceof Shield,
			Kind::Protection => $singleton instanceof Protection,
			Kind::Transport  => $singleton instanceof Transport,
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

	public function setResources(Resources $resources): Container {
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
}
