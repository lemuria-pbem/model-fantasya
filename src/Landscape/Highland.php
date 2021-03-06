<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Landscape;

use JetBrains\PhpStorm\Pure;

/**
 * The stony highland is similar to a plain, with roughly half the number of workplaces.
 */
final class Highland extends AbstractLandscape
{
	private const WORKPLACES = 4000;

	#[Pure] public function Workplaces(): int {
		return self::WORKPLACES;
	}
}
