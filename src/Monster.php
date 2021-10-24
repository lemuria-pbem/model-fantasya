<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\Pure;

interface Monster extends Protection, Race
{
	/**
	 * Get the trophy that can be gained in combat against this monster.
	 */
	#[Pure] public function Trophy(): ?Trophy;
}
