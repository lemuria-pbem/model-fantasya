<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Landscape;

/**
 * The stony highland is similar to a plain, with roughly half the number of workplaces.
 */
final class Highland extends AbstractLandscape
{
	private const WORKPLACES = 4000;

	/**
	 * Get the number of workplaces available for peasants.
	 *
	 * @return int
	 */
	public function Workplaces(): int {
		return self::WORKPLACES;
	}
}
