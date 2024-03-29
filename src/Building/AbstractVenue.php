<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use Lemuria\Model\Fantasya\Building;

/**
 * Base class for NPC buildings.
 */
abstract class AbstractVenue extends AbstractBuilding
{
	public function Dependency(): ?Building {
		return Building::IS_INDEPENDENT;
	}

	public function Feed(): int {
		return 0;
	}

	public function Talent(): int {
		return 0;
	}

	public function Upkeep(): int {
		return Building::IS_FREE;
	}

	public function UsefulSize(): int {
		return 0;
	}

	protected function material(): array {
		return [];
	}
}
