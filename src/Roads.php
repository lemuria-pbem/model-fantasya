<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Exception\UnserializeException;
use Lemuria\Model\World\Direction;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;

class Roads implements \ArrayAccess, \Countable, Serializable
{
	use SerializableTrait;

	/**
	 * @var array<string, float>
	 */
	private array $completion = [];

	/**
	 * Check if a road in the specified direction exists.
	 *
	 * @param Direction|string $offset
	 */
	public function offsetExists(mixed $offset): bool {
		return isset($this->completion[$this->offset($offset)]);
	}

	/**
	 * Get completion of a road.
	 *
	 * @param Direction|string $offset
	 */
	public function offsetGet(mixed $offset): float {
		return $this->completion[$this->offset($offset)] ?? 0.0;
	}

	/**
	 * Set completion of a road.
	 *
	 * @param Direction|string $offset
	 * @param float $value
	 */
	public function offsetSet(mixed $offset, mixed $value): void {
		$this->completion[$this->offset($offset)] = max(0.0, min(1.0, (float)$value));
	}

	/**
	 * Remove a road.
	 *
	 * @param Direction|string $offset
	 */
	public function offsetUnset(mixed $offset): void {
		unset($this->completion[$this->offset($offset)]);
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
	 * @param array<string, mixed> $data
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

	private function offset(mixed $offset): string {
		return $offset instanceof Direction ? $offset->value : $offset;
	}
}
