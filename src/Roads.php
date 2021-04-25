<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Exception\UnserializeException;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;

class Roads implements \ArrayAccess, \Countable, Serializable
{
	use SerializableTrait;

	/**
	 * @var array(string=>float)
	 */
	private array $completion = [];

	/**
	 * Check if a road in the specified direction exists.
	 *
	 * @param string $offset
	 */
	public function offsetExists($offset): bool {
		return isset($this->completion[$offset]);
	}

	/**
	 * Get completion of a road.
	 *
	 * @param string $offset
	 */
	public function offsetGet($offset): float {
		return $this->completion[$offset] ?? 0.0;
	}

	/**
	 * Set completion of a road.
	 *
	 * @param string $offset
	 * @param float $value
	 */
	public function offsetSet($offset, $value): void {
		$this->completion[$offset] = max(0.0, min(1.0, (float)$value));
	}

	/**
	 * Remove a road.
	 *
	 * @param string $offset
	 */
	public function offsetUnset($offset): void {
		unset($this->completion[$offset]);
	}

	/**
	 * Get the number of roads.
	 */
	public function count(): int {
		return count($this->completion);
	}

	/**
	 * Get a plain data array of the model's data.
	 */
	public function serialize(): array {
		return $this->completion;
	}

	/**
	 * Restore the model's data from serialized data.
	 */
	public function unserialize(array $data): Serializable {
		$this->completion = [];
		foreach ($data as $direction => $completion) {
			$this->offsetSet($direction, $completion);
		}
		return $this;
	}

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array (string=>mixed) $data
	 */
	protected function validateSerializedData(array $data): void {
		foreach ($data as $direction => $completion) {
			if (!is_string($direction)) {
				throw new UnserializeException('Direction must be string.');
			}
			if (!is_float($completion)) {
				throw new UnserializeException('Completion must be float.');
			}
		}
	}
}
