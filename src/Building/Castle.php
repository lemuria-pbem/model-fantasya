<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Building;

use Lemuria\Model\Lemuria\Building;

/**
 * A castle is a fortified building where units can hide and trade on the market.
 */
interface Castle extends Building
{
	public const MARKET_SIZE = 5;

	/**
	 * Get the defense value.
	 *
	 * @return int
	 */
	public function Defense(): int;

	/**
	 * Get the maximum size for this kind of castle.
	 *
	 * @return int
	 */
	public function MaxSize(): int;

	/**
	 * Get the minimum size for this kind of castle.
	 *
	 * @return int
	 */
	public function MinSize(): int;

	/**
	 * Get the kind of castle when this castle is upgraded.
	 *
	 * @return Castle
	 */
	public function Upgrade(): Castle;

	/**
	 * Get the wage for peasants and working units.
	 *
	 * @return int
	 */
	public function Wage(): int;
}
