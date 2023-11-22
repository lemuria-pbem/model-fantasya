<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Potion;

use Lemuria\Model\Fantasya\Commodity\Herb\CobaltFungus;
use Lemuria\Model\Fantasya\Commodity\Herb\Knotroot;
use Lemuria\Model\Fantasya\Commodity\Herb\Peyote;
use Lemuria\Model\Fantasya\Commodity\Herb\TangyTemerity;

final class HorseBliss extends AbstractPotion
{
	public final const int HORSES = 50;

	private const int LEVEL = 3;

	private const int WEEKS = 3;

	/**
	 * @type array<string>
	 */
	private const array INGREDIENTS = [CobaltFungus::class, Knotroot::class, Peyote::class, TangyTemerity::class];

	public function Level(): int {
		return self::LEVEL;
	}

	public function Weeks(): int {
		return self::WEEKS;
	}

	/**
	 * @return array<string, int>
	 */
	protected function material(): array {
		return array_fill_keys(self::INGREDIENTS, 1);
	}
}
