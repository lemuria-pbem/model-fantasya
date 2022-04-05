<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Statistics\Data;

use JetBrains\PhpStorm\Pure;

use function Lemuria\getClass;
use Lemuria\Exception\LemuriaException;
use Lemuria\Exception\UnserializeException;
use Lemuria\Model\Fantasya\Commodity;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Statistics\Data;
use Lemuria\Statistics\Data\Number;

class Commodities implements \ArrayAccess, \Countable, \Iterator, Data
{
	use BuilderTrait;

	/**
	 * @var array(string=>Number)
	 */
	protected array $commodities = [];

	private array $keys;

	private int $index;

	/**
	 * @param string|Commodity $offset
	 */
	#[Pure] public function offsetExists(mixed $offset): bool {
		return isset($this->commodities[getClass($offset)]);
	}

	/**
	 * @param string|Commodity $offset
	 */
	#[Pure] public function offsetGet(mixed $offset): ?Number {
		return $this->commodities[getClass($offset)] ?? null;
	}

	/**
	 * @param string|Commodity $offset
	 * @param Number $value
	 */
	public function offsetSet(mixed $offset, mixed $value): void {
		if ($value instanceof Number) {
			$this->commodities[getClass($offset)] = $value;
		} else {
			throw new LemuriaException();
		}
	}

	/**
	 * @param string|Commodity $offset
	 */
	public function offsetUnset(mixed $offset): void {
		unset($this->commodities[getClass($offset)]);
	}

	public function count(): int {
		return count($this->commodities);
	}

	public function current(): Number {
		return $this->commodities[$this->key()];
	}

	public function key(): string {
		return $this->keys[$this->index];
	}

	public function next(): void {
		$this->index++;
	}

	public function rewind(): void {
		$this->keys  = array_keys($this->commodities);
		$this->index = 0;
	}

	public function valid(): bool {
		return $this->index < count($this->keys);
	}

	#[Pure] public function serialize(): array {
		$data = [];
		foreach ($this->commodities as $class => $number /* @var Number $number */) {
			$data[$class] = $number->serialize();
		}
		return $data;
	}

	public function unserialize(mixed $data): Data {
		if (is_array($data)) {
			foreach ($data as $class => $numberData) {
				self::createCommodity($class);
				$number                    = new Number(0);
				$this->commodities[$class] = $number->unserialize($numberData);
			}
			return $this;
		}
		throw new UnserializeException();
	}
}
