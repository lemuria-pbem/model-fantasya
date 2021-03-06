<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\Pure;

use Lemuria\Singleton;

/**
 * The landscape of a region defines its limits.
 */
interface Landscape extends Singleton
{
	/**
	 * Get the number of workplaces available for peasants.
	 */
	#[Pure] public function Workplaces(): int;
}
