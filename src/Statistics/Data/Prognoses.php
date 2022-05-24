<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Statistics\Data;

use function Lemuria\getClass;
use Lemuria\Exception\LemuriaException;
use Lemuria\Exception\UnserializeException;
use Lemuria\Lemuria;
use Lemuria\Singleton;
use Lemuria\Statistics\Data;
use Lemuria\Statistics\Data\Prognosis;

/**
 * @\ArrayAccess<Singleton|string, Prognosis>
 * @\Iterator<string, Prognosis>
 */
class Prognoses implements \ArrayAccess, \Countable, \Iterator, Data
{
	/**
	 * @var array(string=>Prognosis)
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
	public function offsetGet(mixed $offset): ?Prognosis {
		return $this->singletons[getClass($offset)] ?? null;
	}

	/**
	 * @param string|Singleton $offset
	 * @param Prognosis $value
	 */
	public function offsetSet(mixed $offset, mixed $value): void {
		if ($value instanceof Prognosis) {
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

	public function current(): Prognosis {
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
		foreach ($this->singletons as $class => $prognosis /* @var Prognosis $prognosis */) {
			$data[$class] = $prognosis->serialize();
		}
		return $data;
	}

	public function unserialize(mixed $data): Data {
		if (is_array($data)) {
			foreach ($data as $class => $prognosisData) {
				Lemuria::Builder()->create($class);
				$prognosis                = new Prognosis(0);
				$this->singletons[$class] = $prognosis->unserialize($prognosisData);
			}
			return $this;
		}
		throw new UnserializeException();
	}
}
