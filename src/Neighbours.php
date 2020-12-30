<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use JetBrains\PhpStorm\Pure;

/**
 * A helper class that encapsulates the neighbour regions of a region.
 */
class Neighbours implements \ArrayAccess
{
	/**
	 * @var array(string=>Region)
	 */
	private array $regions = [];

	/**
	 * Check if a region in the specified direction exists.
	 *
	 * @param string $offset
	 */
	#[Pure] public function offsetExists(mixed $offset): bool {
		return isset($this->regions[$offset]);
	}

	/**
	 * Get the region in the specified direction.
	 *
	 * @param string $offset
	 */
	#[Pure] public function offsetGet(mixed $offset): ?Region {
		return $this->regions[$offset] ?? null;
	}

	/**
	 * Set the region in the specified direction.
	 *
	 * @param string $offset
	 * @param Region $value
	 */
	public function offsetSet(mixed $offset, mixed $value): void {
		$this->regions[$offset] = $value;
	}

	/**
	 * Unset the region in the specified direction.
	 *
	 * @param string $offset
	 */
	public function offsetUnset(mixed $offset): void {
		unset($this->regions[$offset]);
	}

	/**
	 * Get all neighbors.
	 *
	 * @return array(string=>Region)
	 */
	#[Pure] public function getAll(): array {
		return $this->regions;
	}
}
