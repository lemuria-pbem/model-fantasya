<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\Pure;

use function Lemuria\getClass;
use Lemuria\Exception\UnserializeException;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;

class Herbage implements Serializable
{
	use BuilderTrait;
	use SerializableTrait;

	private Herb $herb;

	private float $occurrence;

	public function Herb(): Herb {
		return $this->herb;
	}

	public function Occurrence(): float {
		return $this->occurrence;
	}

	/**
	 * Get a plain data array of the model's data.
	 */
	#[Pure] public function serialize(): array {
		return [getClass($this->herb) => $this->occurrence];
	}

	/**
	 * Restore the model's data from serialized data.
	 */
	public function unserialize(array $data): Serializable {
		reset($data);
		$herb = self::createCommodity(key($data));
		if ($herb instanceof Herb) {
			$this->herb       = $herb;
			$this->occurrence = current($data);
			return $this;
		}
		throw new UnserializeException('Commodity is not a Herb.');
	}

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array (string=>float) $data
	 */
	protected function validateSerializedData(array $data): void {
		if (count($data) !== 1) {
			throw new UnserializeException('Array must have exactly one entry.');
		}
		foreach ($data as $class => $occurrence) {
			if (!is_string($class)) {
				throw new UnserializeException('Herb must be string.');
			}
			if (!is_float($occurrence)) {
				throw new UnserializeException('Occurrence must be float.');
			}
		}
	}
}