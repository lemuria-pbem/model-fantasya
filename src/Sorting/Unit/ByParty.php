<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Sorting\Unit;

use Lemuria\EntityOrder;
use Lemuria\EntitySet;
use Lemuria\Model\Fantasya\Party;
use Lemuria\Model\Fantasya\Unit;

/**
 * An ordering for units by their party.
 */
readonly class ByParty implements EntityOrder
{
	public function __construct(private Party $party) {
	}

	/**
	 * @return array<int>
	 */
	public function sort(EntitySet $set): array {
		$own     = $this->party->Id()->Id();
		$parties = [$own => []];
		foreach ($set as $unit /* @var Unit $unit */) {
			$party             = $unit->Party()->Id()->Id();
			$parties[$party][] = $unit->Id()->Id();
		}

		$people = $parties[$own];
		unset($parties[$own]);
		ksort($parties);
		$people = array_merge($people, ...$parties);
		return $people;
	}
}
