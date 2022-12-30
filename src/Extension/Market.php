<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Extension;

use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Market\Tradeables;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;
use Lemuria\Validate;

class Market extends Fee
{
	use BuilderTrait;
	use ExtensionTrait;
	use SerializableTrait;

	private const TRADEABLES = 'tradeables';

	protected Tradeables $tradeables;

	public function __construct() {
		$this->tradeables = new Tradeables();
	}

	public function Tradeables(): Tradeables {
		return $this->tradeables;
	}

	public function serialize(): array {
		$data                    = parent::serialize();
		$data[self::TRADEABLES] = $this->tradeables->serialize();
		return $data;
	}

	public function unserialize(array $data): Serializable {
		parent::unserialize($data);
		$this->tradeables->unserialize($data[self::TRADEABLES]);
		return $this;
	}

	/**
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array $data): void {
		parent::validateSerializedData($data);
		$this->validate($data, self::TRADEABLES, Validate::Array);
	}
}
