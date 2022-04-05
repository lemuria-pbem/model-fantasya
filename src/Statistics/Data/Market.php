<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Statistics\Data;

use JetBrains\PhpStorm\Pure;

use Lemuria\Exception\LemuriaException;
use Lemuria\Model\Fantasya\Commodity;
use function Lemuria\getClass;
use Lemuria\Exception\UnserializeException;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Luxuries;
use Lemuria\Statistics\Data;
use Lemuria\Statistics\Data\Number;

class Market implements \ArrayAccess, Data
{
	use BuilderTrait;

	protected array $commodities;

	private static ?array $luxuries = null;

	private static function luxuries(): array {
		if (!self::$luxuries) {
			self::$luxuries = [];
			foreach (Luxuries::LUXURIES as $luxury) {
				self::$luxuries[] = getClass($luxury);
			}
		}
		return self::$luxuries;
	}

	public function __construct() {
		foreach (self::luxuries() as $luxury) {
			$this->commodities[$luxury] = new Number(0);
		}
	}

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
		$class = getClass($offset);
		if ($this->commodities[$class] instanceof Number) {
			$this->commodities[$class]->value  = 0;
			$this->commodities[$class]->change = null;
		}
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
				if (!isset($this->commodities[$class])) {
					throw new UnserializeException();
				}
				$this->commodities[$class]->unserialize($numberData);
			}
			return $this;
		}
		throw new UnserializeException();
	}
}
