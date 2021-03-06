<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Landscape;

use JetBrains\PhpStorm\Pure;

/**
 * A desert is a landscape full of sand, where fauna and flora is sparse.
 */
final class Desert extends AbstractLandscape
{
	private const WORKPLACES = 500;

	#[Pure] public function Workplaces(): int {
		return self::WORKPLACES;
	}
}
