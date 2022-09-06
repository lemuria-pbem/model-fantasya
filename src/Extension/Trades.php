<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Extension;

use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;

class Trades extends AbstractExtension
{
	use BuilderTrait;
	use SerializableTrait;

	public function __construct() {
	}

	public function serialize(): array {
		$data = [];

		return $data;
	}

	public function unserialize(array $data): Serializable {
		$this->validateSerializedData($data);

		return $this;
	}

	/**
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array $data): void {
		$this->validate($data, 'tradeables', 'array');
	}
}
