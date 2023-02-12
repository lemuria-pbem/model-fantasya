<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Extension;

use Lemuria\Model\Fantasya\Extension;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;
use Lemuria\Validate;

class Duty implements Extension
{
	use ExtensionTrait;
	use SerializableTrait;

	private const DUTY = 'duty';

	protected float $duty = 0.0;

	public function Duty(): float {
		return $this->duty;
	}

	public function serialize(): array {
		return [self::DUTY => $this->duty];
	}

	public function unserialize(array $data): Serializable {
		$this->validateSerializedData($data);
		$this->duty = $data[self::DUTY];
		return $this;
	}

	public function setDuty(float $duty): Duty {
		$this->duty = $duty;
		return $this;
	}

	/**
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array $data): void {
		$this->validate($data, self::DUTY, Validate::Float);
	}
}
