<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Potion;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Herb\Bugleweed;
use Lemuria\Model\Fantasya\Commodity\Herb\Mandrake;
use Lemuria\Model\Fantasya\Commodity\Herb\Owlsgaze;
use Lemuria\Model\Fantasya\Commodity\Herb\Sandreeker;
use Lemuria\Model\Fantasya\Commodity\Herb\WhiteHemlock;

final class BerserkBlood extends AbstractPotion
{
	public final const PERSONS = 10;

	private const LEVEL = 4;

	private const INGREDIENTS = [Bugleweed::class, Mandrake::class, Owlsgaze::class, Sandreeker::class, WhiteHemlock::class];

	#[Pure] public function Level(): int {
		return self::LEVEL;
	}

	/**
	 * @return array(string=>int)
	 */
	#[Pure] protected function material(): array {
		return array_fill_keys(self::INGREDIENTS, 1);
	}
}
