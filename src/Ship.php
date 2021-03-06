<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\Pure;

/**
 * Describes the types of ships in Lemuria.
 */
interface Ship extends Artifact, Transport
{
	/**
	 * Get the minimum sailing talent for the captain to navigate.
	 */
	#[Pure] public function Captain(): int;

	/**
	 * Get the minimum total sailing ability to sail the ship.
	 */
	#[Pure] public function Crew(): int;

	/**
	 * Get the amount of wood needed to build the ship.
	 */
	#[Pure] public function Wood(): int;
}
