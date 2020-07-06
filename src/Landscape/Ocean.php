<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Landscape;

/**
 * The ocean, full of water.
 */
final class Ocean extends AbstractLandscape
{
	private const WORKPLACES = 0;

	/**
	 * Get the number of workplaces available for peasants.
	 *
	 * @return int
	 */
	public function Workplaces(): int {
		return self::WORKPLACES;
	}
}
