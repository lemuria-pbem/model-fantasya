<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Statistics\Data;

use function Lemuria\getClass;
use Lemuria\Exception\LemuriaException;
use Lemuria\Exception\UnserializeException;
use Lemuria\Lemuria;
use Lemuria\Singleton;
use Lemuria\Statistics\Data;
use Lemuria\Statistics\Data\Number;

/**
 * @\ArrayAccess<Singleton|string, Number>
 * @\Iterator<string, Number>
 */
class Singletons implements \ArrayAccess, \Countable, \Iterator, Data
{
	/**
	 * @var array<string, Number>
	 */
	protected array $singletons = [];

	private array $keys;

	private int $index;

	/**
	 * @param string|Singleton $offset
	 */
	public function offsetExists(mixed $offset): bool {
		return isset($this->singletons[getClass($offset)]);
	}

	/**
	 * @param string|Singleton $offset
	 */
	public function offsetGet(mixed $offset): ?Number {
		return $this->singletons[getClass($offset)] ?? null;
	}

	/**
	 * @param string|Singleton $offset
	 * @param Number $value
	 */
	public function offsetSet(mixed $offset, mixed $value): void {
		if ($value instanceof Number) {
			$this->singletons[getClass($offset)] = $value;
		} else {
			throw new LemuriaException();
		}
	}

	/**
	 * @param string|Singleton $offset
	 */
	public function offsetUnset(mixed $offset): void {
		unset($this->singletons[getClass($offset)]);
	}

	public function count(): int {
		return count($this->singletons);
	}

	public function current(): Number {
		return $this->singletons[$this->key()];
	}

	public function key(): string {
		return $this->keys[$this->index];
	}

	public function next(): void {
		$this->index++;
	}

	public function rewind(): void {
		$this->keys  = array_keys($this->singletons);
		$this->index = 0;
	}

	public function valid(): bool {
		return $this->index < count($this->keys);
	}

	public function serialize(): array {
		$data = [];
		foreach ($this->singletons as $class => $number /* @var Number $number */) {
			$data[$class] = $number->serialize();
		}
		return $data;
	}

	public function unserialize(mixed $data): static {
		if (is_array($data)) {
			foreach ($data as $class => $numberData) {
				Lemuria::Builder()->create($class);
				$number                   = new Number(0);
				$this->singletons[$class] = $number->unserialize($numberData);
			}
			return $this;
		}
		throw new UnserializeException();
	}
}
