<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\Pure;

interface Potion extends Artifact, Commodity
{
	/**
	 * The potion level.
	 */
	#[Pure] public function Level(): int;

	/**
	 * The effect duration of the potion.
	 */
	#[Pure] public function Weeks(): int;
}
