<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Landscape;

use JetBrains\PhpStorm\Pure;

/**
 * A swamp is like a plain, but there are many moors and few peasants can make it their home.
 */
final class Swamp extends AbstractLandscape
{
	private const WORKPLACES = 2000;

	#[Pure] public function Workplaces(): int {
		return self::WORKPLACES;
	}
}
