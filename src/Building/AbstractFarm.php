<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use Lemuria\Model\Fantasya\Building;

/**
 * A working place for peasants.
 */
abstract class AbstractFarm extends AbstractBuilding
{
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
}
