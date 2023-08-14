<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Exception\LemuriaException;
use Lemuria\Exception\UnserializeEntityException;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;
use Lemuria\Validate;

class Aura implements Serializable
{
	use SerializableTrait;

	private const AURA = 'aura';

	private const MAXIMUM = 'maximum';

	private int $aura = 0;

	private int $maximum = 0;

	public function Aura(): int {
		return $this->aura;
	}

	public function Maximum(): int {
		return $this->maximum;
	}

	public function serialize(): array {
		return [self::AURA => $this->aura, self::MAXIMUM => $this->maximum];
	}

	public function unserialize(array $data): static {
		$this->validateSerializedData($data);
		$this->aura    = $data[self::AURA];
		$this->maximum = $data[self::MAXIMUM];
		return $this;
	}

	public function setAura(int $aura): static {
		$this->aura = $aura;
		return $this;
	}

	public function setMaximum(int $maximum): static {
		$this->maximum = $maximum;
		return $this;
	}

	public function consume(int $aura): static {
		if ($aura > $this->aura) {
			throw new LemuriaException('The magician has not enough Aura left.');
		}

		$this->aura -= $aura;
		return $this;
	}

	/**
	 * @param array<string, mixed> $data
	 * @throws UnserializeEntityException
	 */
	protected function validateSerializedData(array $data): void {
		$this->validate($data, self::AURA, Validate::Int);
		$this->validate($data, self::MAXIMUM, Validate::Int);
	}
}
