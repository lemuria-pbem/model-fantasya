<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Potion;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Herb\CobaltFungus;
use Lemuria\Model\Fantasya\Commodity\Herb\Knotroot;
use Lemuria\Model\Fantasya\Commodity\Herb\Peyote;
use Lemuria\Model\Fantasya\Commodity\Herb\TangyTemerity;

final class HorseBliss extends AbstractPotion
{
	public const HORSES = 50;

	private const LEVEL = 3;

	private const WEEKS = 3;

	private const INGREDIENTS = [CobaltFungus::class, Knotroot::class, Peyote::class, TangyTemerity::class];

	#[Pure] public function Level(): int {
		return self::LEVEL;
	}

	#[Pure] public function Weeks(): int {
		return self::WEEKS;
	}

	/**
	 * @return array(string=>int)
	 */
	#[Pure] protected function material(): array {
		return array_fill_keys(self::INGREDIENTS, 1);
	}
}
