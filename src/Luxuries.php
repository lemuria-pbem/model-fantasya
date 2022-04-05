<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

use function Lemuria\getClass;
use Lemuria\CountableTrait;
use Lemuria\IteratorTrait;
use Lemuria\Exception\LemuriaException;
use Lemuria\Exception\UnserializeException;
use Lemuria\Model\Fantasya\Commodity\Luxury\Balsam;
use Lemuria\Model\Fantasya\Commodity\Luxury\Fur;
use Lemuria\Model\Fantasya\Commodity\Luxury\Gem;
use Lemuria\Model\Fantasya\Commodity\Luxury\Myrrh;
use Lemuria\Model\Fantasya\Commodity\Luxury\Oil;
use Lemuria\Model\Fantasya\Commodity\Luxury\Olibanum;
use Lemuria\Model\Fantasya\Commodity\Luxury\Silk;
use Lemuria\Model\Fantasya\Commodity\Luxury\Spice;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;

/**
 * Represents the prices of luxuries on the market of a region.
 */
class Luxuries implements \ArrayAccess, \Countable, \Iterator, Serializable
{
	use BuilderTrait;
	use CountableTrait;
	use IteratorTrait;
	use SerializableTrait;

	public final const LUXURIES = [
		Balsam::class, Fur::class, Gem::class, Myrrh::class, Oil::class, Olibanum::class, Silk::class, Spice::class
	];

	private ?Offer $offer;

	/**
	 * @var array(string=>Offer)
	 */
	private array $demand = [];

	/**
	 * @var array(int=>string)
	 */
	private array $indices = [];

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
	 */
	#[Pure] public function offsetExists(mixed $offset): bool {
		$class = getClass($offset);
		return isset($this->demand[$class]);
	}

	/**
	 * Get a demand.
	 *
	 * @param Luxury|string $offset
	 */
	public function offsetGet(mixed $offset): Offer {
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
	public function offsetSet(mixed $offset, mixed $value): void {
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
	public function offsetUnset(mixed $offset): void {
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
	 */
	#[Pure] public function count(): int {
		return count($this->demand);
	}

	#[Pure]	public function current(): ?Offer {
		$key = $this->key();
		return $this->demand[$key] ?? null;
	}

	#[Pure] public function key(): ?string {
		return $this->indices[$this->index] ?? null;
	}

	/**
	 * Get a plain data array of the model's data.
	 */
	#[ArrayShape(['offer' => "string", 'price' => 'int', 'demand' => "array"])] public function serialize(): array {
		$offer  = getClass($this->Offer()->Commodity());
		$price  = $this->Offer()->Price();
		$demand = [];
		foreach ($this->demand as $class => $item/* @var Offer $item */) {
			$demand[$class] = $item->Price();
		}
		return ['offer' => $offer, 'price' => $price, 'demand' => $demand];
	}

	/**
	 * Restore the model's data from serialized data.
	 */
	public function unserialize(array $data): Serializable {
		$class  = $data['offer'];
		$price  = $data['price'];
		$luxury = self::createCommodity($class);
		/* @var Luxury $luxury */
		$this->offer = new Offer($luxury, $price);
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

	public function Offer(): Offer {
		if (!$this->offer) {
			throw new LemuriaException('Offer has not been initialized.');
		}
		return $this->offer;
	}

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array (string=>mixed) $data
	 */
	protected function validateSerializedData(array &$data): void {
		$this->validate($data, 'offer', 'string');
		$this->validate($data, 'price', 'int');
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
		$i = 0;
		foreach (self::LUXURIES as $class) {
			$luxury = self::createCommodity($class);
			if ($luxury === $offer) {
				continue;
			}
			$class                = getClass($class);
			$this->demand[$class] = new Offer($luxury);
			$this->indices[$i++]  = $class;
		}
		$this->index = 0;
		$this->count = count($this->demand);
	}
}
