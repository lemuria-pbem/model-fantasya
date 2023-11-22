<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use Lemuria\Model\Fantasya\Building;
use Lemuria\Model\Fantasya\Commodity\Iron;
use Lemuria\Model\Fantasya\Commodity\Silver;
use Lemuria\Model\Fantasya\Commodity\Wood;

/**
 * Small ships can dock at a quay in regions where they could not do otherwise.
 */
final class Quay extends AbstractBuilding
{
	private const int TALENT = 2;

	private const int UPKEEP = 30;

	private const int USEFUL_SIZE = 5;

	private const int SILVER = 50;

	private const int WOOD = 2;

	private const int IRON = 1;

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

	protected function material(): array {
		return [Silver::class => self::SILVER, Wood::class => self::WOOD, Iron::class => self::IRON];
	}
}
