<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\World;

use JetBrains\PhpStorm\ExpectedValues;

use Lemuria\Model\Fantasya\Sorting\Region\ByResidents;
use Lemuria\Model\World\Atlas;

class FantasyaAtlas extends Atlas
{
	/**
	 * Sort mode by number of residents.
	 */
	public const BY_RESIDENTS = 2;

	public function sort(#[ExpectedValues(values: [self::BY_ID, self::NORTH_TO_SOUTH, self::BY_RESIDENTS])] int $mode = self::BY_ID): Atlas {
		switch ($mode) {
			case self::BY_RESIDENTS :
				$this->sortUsing(new ByResidents());
				break;
			default :
				/** @noinspection PhpExpectedValuesShouldBeUsedInspection */
				return parent::sort($mode);
		}
		return $this;
	}
}
