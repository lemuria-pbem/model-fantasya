<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

/**
 * Describes the types of ships in Lemuria.
 */
interface Ship extends Artifact, Transport
{
	/**
	 * Get the minimum sailing talent for the captain to navigate.
	 */
	public function Captain(): int;

	/**
	 * Get the minimum total sailing ability to sail the ship.
	 */
	public function Crew(): int;

	/**
	 * Get the amount of wood needed to build the ship.
	 */
	public function Wood(): int;

	/**
	 * Get the tare weight.
	 */
	public function Tare(): int;
}
