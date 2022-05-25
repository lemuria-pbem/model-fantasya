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
 * @\ArrayAccess<Singleton|string, array<int, Prognosis>>
 * @\Iterator<string, array<int, Prognosis>>
 */
class Qualification implements \ArrayAccess, \Countable, \Iterator, Data
{
	/**
	 * @var array<string, Prognosis>
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
	 * @return array<int, Prognosis>
	 */
	public function offsetGet(mixed $offset): ?array {
		return $this->singletons[getClass($offset)] ?? null;
	}

	/**
	 * @param string|Singleton $offset
	 * @param array<int, Prognosis> $value
	 */
	public function offsetSet(mixed $offset, mixed $value): void {
		if ($this->isQualification($value)) {
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

	/**
	 * @return array<int, Prognosis>
	 */
	public function current(): array {
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
		foreach ($this->singletons as $class => $prognoses) {
			$values = [];
			foreach ($prognoses as $level => $prognosis /* @var Prognosis $prognosis */) {
				$values[$level] = $prognosis->serialize();
			}
			$data[$class] = $values;
		}
		return $data;
	}

	public function unserialize(mixed $data): Data {
		if (is_array($data)) {
			foreach ($data as $class => $prognosesData) {
				Lemuria::Builder()->create($class);
				if (!is_array($prognosesData)) {
					throw new UnserializeException();
				}
				$values = [];
				foreach ($prognosesData as $level => $prognosisData) {
					$prognosis      = new Prognosis(0);
					$values[$level] = $prognosis->unserialize($prognosisData);
				}
				$this->singletons[$class] = $values;
			}
			return $this;
		}
		throw new UnserializeException();
	}

	private function isQualification(mixed $value): bool {
		if (!is_array($value)) {
			return false;
		}
		foreach ($value as $level => $prognosis) {
			if (!is_int($level)) {
				return false;
			}
			if (!($prognosis instanceof Prognosis)) {
				return false;
			}
		}
		return true;
	}
}
