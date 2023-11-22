<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use Lemuria\Model\Fantasya\Animal;
use Lemuria\Model\Fantasya\Building;
use Lemuria\Model\Fantasya\Commodity\Iron;
use Lemuria\Model\Fantasya\Commodity\Silver;
use Lemuria\Model\Fantasya\Commodity\Stone;
use Lemuria\Model\Fantasya\Commodity\Wood;

/**
 * A horse breeding farm.
 */
abstract class AbstractBreeding extends AbstractBuilding
{
	private const int TALENT = 3;

	private const int UPKEEP = 100;

	private const int FEED = 5;

	private const int SILVER = 100;

	private const int WOOD = 5;

	private const int STONE = 3;

	private const int IRON = 2;

	private const int USEFUL_SIZE = 3;

	public function Dependency(): ?Building {
		return Building::IS_INDEPENDENT;
	}

	public function Feed(): int {
		return self::FEED;
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

	abstract public function Animal(): Animal;

	protected function material(): array {
		return [Silver::class => self::SILVER, Wood::class => self::WOOD, Stone::class => self::STONE, Iron::class => self::IRON];
	}
}
