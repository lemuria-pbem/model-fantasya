<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use function Lemuria\getClass;
use Lemuria\CountableTrait;
use Lemuria\Exception\SingletonException;
use Lemuria\Exception\SingletonSetException;
use Lemuria\Exception\UnserializeException;
use Lemuria\IteratorTrait;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Serializable;

class Quotas implements \ArrayAccess, \Countable, \Iterator, Serializable
{
	use BuilderTrait;
	use CountableTrait;
	use IteratorTrait;

	/**
	 * @var array<string>
	 */
	private array $indices = [];

	/**
	 * @var array<string, Quota>
	 */
	private array $quota = [];

	/**
	 * @param Commodity|string $offset
	 */
	public function offsetExists(mixed $offset): bool {
		$class = getClass($offset);
		return isset($this->quota[$class]);
	}

	/**
	 * @param Commodity|string $offset
	 */
	public function offsetGet(mixed $offset): Quota {
		$class = getClass($offset);
		if (isset($this->quota[$class])) {
			return $this->quota[$class];
		}
		throw new SingletonSetException($offset);
	}

	/**
	 * @param Commodity|string $offset
	 * @param Quota $value
	 */
	public function offsetSet(mixed $offset, mixed $value): void {
		$this->add($value);
	}

	/**
	 * @param Commodity|Quota|string $offset
	 */
	public function offsetUnset(mixed $offset): void {
		$this->delete($offset);
	}

	public function current(): ?Quota {
		$key = $this->key();
		return $key !== null ? $this->quota[$key] : null;
	}

	public function key(): ?string {
		return $this->indices[$this->index] ?? null;
	}

	/**
	 * @return array<string, array>
	 */
	public function serialize(): array {
		$data = [];
		foreach ($this->quota as $commodity => $quota) {
			$data[$commodity] = $quota->Threshold();
		}
		return $data;
	}

	/**
	 * @param array<string, int|float> $data
	 */
	public function unserialize(array $data): static {
		$this->validateSerializedData($data);
		if ($this->count() > 0) {
			$this->clear();
		}
		foreach ($data as $class => $threshold) {
			$commodity = self::createCommodity($class);
			$this->add(new Quota($commodity, $threshold));
		}
		return $this;
	}


	/**
	 * Add a singleton to the set.
	 */
	public function add(Quota $quota): void {
		$class = getClass($quota->Commodity());
		if (!isset($this->quota[$class])) {
			$this->quota[$class] = $quota;
			$this->indices[]     = $class;
			$this->count++;
		}
	}

	/**
	 * Remove the singleton of the specified class from the set.
	 */
	public function delete(string|Commodity|Quota $commodity): void {
		$class = getClass($commodity instanceof Quota ? $commodity->Commodity() : $commodity);
		unset($this->singletons[$class]);
		$this->indices = array_keys($this->singletons);
		$this->count--;
		if ($this->index >= $this->count) {
			if ($this->count === 0) {
				$this->index = 0;
			} else {
				$this->index--;
			}
		}
	}

	/**
	 * Clear the set.
	 */
	public function clear(): static {
		$this->indices = [];
		$this->quota   = [];
		$this->index   = 0;
		$this->count   = 0;
		return $this;
	}

	public function getQuota(Commodity $commodity): ?Quota {
		$class = getClass($commodity);
		return $this->quota[$class] ?? null;
	}

	protected function validateCommodity(mixed $commodity): void {
		if (!($commodity instanceof Commodity)) {
			throw new SingletonException($commodity);
		}
	}

	/**
	 * @param array<string, int|float> $data
	 */
	protected function validateSerializedData(array $data): void {
		foreach ($data as $class => $threshold) {
			if (!is_string($class)) {
				throw new UnserializeException('Quota key must be string.');
			}
			if (!is_int($threshold) && !is_float($threshold)) {
				throw new UnserializeException('Quota threshold must be numeric.');
			}
		}
	}
}
