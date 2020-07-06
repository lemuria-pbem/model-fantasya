<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Landscape;

/**
 * A desert is a landscape full of sand, where fauna and flora is sparse.
 */
final class Desert extends AbstractLandscape
{
	private const WORKPLACES = 500;

	/**
	 * Get the number of workplaces available for peasants.
	 *
	 * @return int
	 */
	public function Workplaces(): int {
		return self::WORKPLACES;
	}
}
