<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use Lemuria\Model\Fantasya\Building;

/**
 * A castle is a fortified building where units can hide and trade on the market.
 */
interface Castle extends Building
{
	public final const MARKET_SIZE = 5;

	public function Defense(): int;

	public function MaxSize(): int;

	public function MinSize(): int;

	public function Downgrade(): Castle;

	public function Upgrade(): Castle;

	public function Wage(): int;
}
