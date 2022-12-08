<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Extension;

use Lemuria\Exception\UnserializeException;
use Lemuria\Model\Fantasya\Extension;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Market\Tradeables;
use Lemuria\Model\Fantasya\Quantity;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;
use Lemuria\Validate;

class Market implements Extension
{
	use BuilderTrait;
	use ExtensionTrait;
	use SerializableTrait;

	private const FEE = 'fee';

	private const TRADEABLES = 'tradeables';

	protected Quantity|float|null $fee = null;

	protected Tradeables $tradeables;

	public function __construct() {
		$this->tradeables = new Tradeables();
	}

	public function Fee(): Quantity|float|null {
		return $this->fee;
	}

	public function Tradeables(): Tradeables {
		return $this->tradeables;
	}

	public function serialize(): array {
		$fee = $this->fee;
		if ($this->fee instanceof Quantity) {
			$fee = [(string)$this->fee->Commodity() => $this->fee->Count()];
		}
		return [self::FEE => $fee, self::TRADEABLES => $this->tradeables->serialize()];
	}

	public function unserialize(array $data): Serializable {
		$this->validateSerializedData($data);
		$fee = $data[self::FEE];
		if (is_array($fee)) {
			$fee = new Quantity(self::createCommodity(key($fee)), current($fee));
		}
		$this->fee = $fee;
		$this->tradeables->unserialize($data[self::TRADEABLES]);
		return $this;
	}

	public function setFee(Quantity|float|null $fee): Market {
		$this->fee = $fee;
		return $this;
	}

	/**
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array $data): void {
		if (!array_key_exists(self::FEE, $data)) {
			throw new UnserializeException('Serialized data has no fee of type array or float.');
		}
		$fee = $data[self::FEE];
		if (is_array($fee)) {
			if (count($fee) !== 1 || !is_string(key($fee)) || !is_int(current($fee))) {
				throw new UnserializeException('Serialized data has no fee of type Quantity array.');
			}
		} else {
			$this->validate($data, self::FEE, Validate::FloatOrNull);
		}
		$this->validate($data, self::TRADEABLES, Validate::Array);
	}
}
