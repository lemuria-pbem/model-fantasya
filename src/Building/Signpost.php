<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use Lemuria\Model\Fantasya\Building;
use Lemuria\Model\Fantasya\Commodity\Iron;
use Lemuria\Model\Fantasya\Commodity\Silver;
use Lemuria\Model\Fantasya\Commodity\Stone;
use Lemuria\Model\Fantasya\Commodity\Wood;

/**
 * A simple signpost that shows a message to visitors in a region.
 */
final class Signpost extends AbstractBuilding
{
	private const int TALENT = 1;

	private const int SILVER = 50;

	private const int WOOD = 1;

	private const int STONE = 1;

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
		return Building::IS_FREE;
	}

	public function UsefulSize(): int {
		return Building::IS_UNLIMITED;
	}

	protected function material(): array {
		return [Silver::class => self::SILVER, Wood::class => self::WOOD, Stone::class => self::STONE, Iron::class => self::IRON];
	}
}
