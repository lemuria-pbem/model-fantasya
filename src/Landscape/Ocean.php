<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Landscape;

use JetBrains\PhpStorm\Pure;

/**
 * The ocean, full of water.
 */
final class Ocean extends AbstractLandscape
{
	private const WORKPLACES = 0;

	#[Pure] public function Workplaces(): int {
		return self::WORKPLACES;
	}
}
