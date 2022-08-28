<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Constraints;

use Lemuria\Exception\UnserializeEntityException;
use Lemuria\Model\Fantasya\Constraints;
use Lemuria\Model\Fantasya\Tradeables;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;

class MarketKeeper implements Constraints
{
	use SerializableTrait;

	protected int|float $fee = 0;

	protected Tradeables $tradeables;

	public function __construct() {
		$this->tradeables = new Tradeables();
	}

	public function Fee(): int|float {
		return $this->fee;
	}

	public function serialize(): array {
		return ['fee' => $this->fee, 'tradeables' => $this->tradeables->serialize()];
	}

	public function unserialize(array $data): Serializable {
		$this->validateSerializedData($data);
		$this->fee = $data['fee'];
		$this->tradeables->unserialize($data['tradeables']);
		return $this;
	}

	public function setFee(int|float $fee): MarketKeeper {
		$this->fee = $fee;
		return $this;
	}

	/**
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array $data): void {
		if (!array_key_exists('fee', $data) || !is_numeric($data['fee'])) {
			throw new UnserializeEntityException('fee', 'int or float');
		}
		$this->validate($data, 'tradeables', 'array');
	}
}
