<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\Pure;

use Lemuria\Singleton;

/**
 * The landscape of a region defines its limits.
 */
interface Landscape extends Singleton
{
	/**
	 * Get the herbs that can be found in this landscape.
	 *
	 * @return Herb[]
	 */
	public function Herbs(): array;

	/**
	 * Get the number of stones that are needed to build a road in one direction.
	 */
	#[Pure] public function RoadStones(): int;

	/**
	 * Get the number of workplaces available for peasants.
	 */
	#[Pure] public function Workplaces(): int;
}
