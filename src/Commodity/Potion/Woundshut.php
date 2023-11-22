<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Potion;

use Lemuria\Model\Fantasya\Commodity\Herb\CaveLichen;
use Lemuria\Model\Fantasya\Commodity\Herb\Peyote;
use Lemuria\Model\Fantasya\Commodity\Herb\TangyTemerity;
use Lemuria\Model\Fantasya\Commodity\Herb\WhiteHemlock;

final class Woundshut extends AbstractPotion
{
	public final const int HITPOINTS = 400;

	private const int LEVEL = 3;

	/**
	 * @type array<string>
	 */
	private const array INGREDIENTS = [CaveLichen::class, Peyote::class, TangyTemerity::class, WhiteHemlock::class];

	public function Level(): int {
		return self::LEVEL;
	}

	/**
	 * @return array<string, int>
	 */
	protected function material(): array {
		return array_fill_keys(self::INGREDIENTS, 1);
	}
}
