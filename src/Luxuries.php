<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use function Lemuria\getClass;
use Lemuria\Exception\LemuriaException;
use Lemuria\Exception\UnserializeException;
use Lemuria\Model\Lemuria\Commodity\Luxury\Balsam;
use Lemuria\Model\Lemuria\Commodity\Luxury\Fur;
use Lemuria\Model\Lemuria\Commodity\Luxury\Gem;
use Lemuria\Model\Lemuria\Commodity\Luxury\Myrrh;
use Lemuria\Model\Lemuria\Commodity\Luxury\Oil;
use Lemuria\Model\Lemuria\Commodity\Luxury\Olibanum;
use Lemuria\Model\Lemuria\Commodity\Luxury\Silk;
use Lemuria\Model\Lemuria\Commodity\Luxury\Spice;
use Lemuria\Model\Lemuria\Factory\BuilderTrait;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;

/**
 * Represents the prices of luxuries on the market of a region.
 */
class Luxuries implements \ArrayAccess, \Countable, \Iterator, Serializable
{
	use BuilderTrait;
	use SerializableTrait;

	protected const LUXURIES = [
		Balsam::class, Fur::class, Gem::class, Myrrh::class, Oil::class, Olibanum::class, Silk::class, Spice::class
	];

	private ?Offer $offer;

	/**
	 * @var array(string=>Offer)
	 */
	private array $demand = [];

	private int $index = 0;

	/**
	 * @var array(int=>string)
	 */
	private array $indices = [];

	private int $count = 0;

	/**
	 * @param Offer|null $offer
	 */
	public function __construct(?Offer $offer = null) {
		$this->offer = $offer;
		if ($offer) {
			$this->initialize();
		}
	}

	/**
	 * Check if a luxury is in demand.
	 *
	 * @param Luxury|string $offset
	 * @return bool
	 */
	public function offsetExists($offset): bool {
		$class = getClass($offset);
		return isset($this->demand[$class]);
	}

	/**
	 * Get a demand.
	 *
	 * @param Luxury|string $offset
	 * @return Offer
	 */
	public function offsetGet($offset): Offer {
		$class = getClass($offset);
		if (!isset($this->demand[$class])) {
			throw new LemuriaException('Demand ' . $class . ' does not exist.');
		}
		return $this->demand[$class];
	}

	/**
	 * Set a demand.
	 *
	 * @param Luxury|string $offset
	 * @param Offer|int $value
	 */
	public function offsetSet($offset, $value): void {
		$class = getClass($offset);
		if (!isset($this->demand[$class])) {
			throw new LemuriaException('Demand ' . $class . ' does not exist.');
		}
		if ($value instanceof Offer) {
			$value = $value->Price();
		} elseif (!is_int($value)) {
			throw new LemuriaException('Invalid value.');
		}
		$this->demand[$class]->setPrice($value);
	}

	/**
	 * Reset a demand price.
	 *
	 * @param Luxury|string $offset
	 */
	public function offsetUnset($offset): void {
		$class = getClass($offset);
		if (!isset($this->demand[$class])) {
			throw new LemuriaException('Demand ' . $class . ' does not exist.');
		}
		$demand = $this->demand[$class];
		/* @var Offer $demand */
		$luxury = $demand->Commodity();
		/* @var Luxury $luxury */
		$this->demand[$class]->setPrice($luxury->Value());
	}

	/**
	 * Get number of demand luxuries.
	 *
	 * @return int
	 */
	public function count(): int {
		return count($this->demand);
	}

	/**
	 * Get current demand.
	 *
	 * @return Offer|null
	 */
	public function current(): ?Offer {
		$key = $this->key();
		return $this->demand[$key] ?? null;
	}

	/**
	 * Get the key.
	 *
	 * @return string|null
	 */
	public function key(): ?string {
		return $this->indices[$this->index] ?? null;
	}

	/**
	 * Set next iterator.
	 */
	public function next(): void {
		$this->index++;
	}

	/**
	 * Reset iterator.
	 */
	public function rewind(): void {
		$this->index = 0;
	}

	/**
	 * Check if iterator is valid.
	 *
	 * @return bool
	 */
	public function valid(): bool {
		return $this->index < $this->count;
	}

	/**
	 * Get a plain data array of the model's data.
	 *
	 * @return array
	 */
	public function serialize(): array {
		$offer  = getClass($this->Offer()->Commodity());
		$demand = [];
		foreach ($this->demand as $class => $item/* @var Offer $item */) {
			$demand[$class] = $item->Price();
		}
		return ['offer' => $offer, 'demand' => $demand];
	}

	/**
	 * Restore the model's data from serialized data.
	 *
	 * @param array $data
	 * @return Serializable
	 */
	public function unserialize(array $data): Serializable {
		$class  = $data['offer'];
		$luxury = self::createCommodity($class);
		/* @var Luxury $luxury */
		$this->offer = new Offer($luxury, $luxury->Value());
		$this->initialize();

		$n = 0;
		foreach ($data['demand'] as $class => $price) {
			if (array_key_exists($class, $this->demand)) {
				if ($this->demand[$class]->Price() > 0) {
					throw new UnserializeException('Luxury already set: ' . $class);
				}
				$this->demand[$class]->setPrice($price);
				$n++;
			} else {
				throw new UnserializeException('Invalid luxury: ' . $class);
			}
		}
		if ($n !== $this->count) {
			throw new UnserializeException('Missing luxuries.');
		}

		return $this;
	}

	/**
	 * Get the offer.
	 *
	 * @return Offer
	 */
	public function Offer(): Offer {
		if (!$this->offer) {
			throw new LemuriaException('Offer has not been initialized.');
		}
		return $this->offer;
	}

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array (string=>mixed) &$data
	 */
	protected function validateSerializedData(&$data): void {
		$this->validate($data, 'offer', 'string');
		$this->validate($data, 'demand', 'array');
		foreach ($data as $class => $price) {
			if (!is_string($class)) {
				throw new UnserializeException('Demand must be string.');
			}
			if (!is_int($price)) {
				throw new UnserializeException('Price must be int.');
			}
		}
	}

	/**
	 * Initialize the demand.
	 */
	protected function initialize(): void {
		$offer = $this->offer->Commodity();
		if (!$offer instanceof Luxury) {
			throw new UnserializeException('Expected luxury: ' . $offer);
		}
		foreach (self::LUXURIES as $class) {
			$luxury = self::createCommodity($class);
			if ($luxury === $offer) {
				continue;
			}
			$this->demand[getClass($class)] = new Offer($luxury);
		}
		$this->index = 0;
		$this->count = count($this->demand);
	}
}
