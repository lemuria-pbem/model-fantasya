<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use Lemuria\Model\Fantasya\Building;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\SingletonSet;

/**
 * A working place for peasants.
 */
abstract class AbstractFarm extends AbstractBuilding implements Farm
{
	use BuilderTrait;

	private const int TALENT = 2;

	private const int UPKEEP = 100;

	private const int USEFUL_SIZE = 1;

	public function Dependency(): ?Building {
		return Building::IS_INDEPENDENT;
	}

	public function Feed(): int {
		return Building::IS_FREE;
	}

	public function Talent(): int {
		return self::TALENT;
	}

	public function Upkeep(): int {
		return self::UPKEEP;
	}

	public function UsefulSize(): int {
		return self::USEFUL_SIZE;
	}

	public function Landscapes(): SingletonSet {
		$landscapes = new SingletonSet();
		foreach ($this->getLandscapes() as $landscape) {
			$landscapes->add(self::createLandscape($landscape));
		}
		return $landscapes;
	}

	/**
	 * @return array<string>
	 */
	abstract protected function getLandscapes(): array;
}
