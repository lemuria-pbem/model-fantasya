<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\ArrayShape;

use Lemuria\Exception\UnserializeEntityException;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;

class Aura implements Serializable
{
	use SerializableTrait;

	private int $aura = 0;

	private int $maximum = 0;

	public function Aura(): int {
		return $this->aura;
	}

	public function Maximum(): int {
		return $this->maximum;
	}

	#[ArrayShape(['aura' => "int", 'maximum' => "int"])]
	public function serialize(): array {
		return ['aura' => $this->aura, 'maximum' => $this->maximum];
	}

	public function unserialize(array $data): Serializable {
		$this->validateSerializedData($data);
		$this->aura    = $data['aura'];
		$this->maximum = $data['maximum'];
		return $this;
	}

	public function setAura(int $aura): Aura {
		$this->aura = $aura;
		return $this;
	}

	public function setMaximum(int $maximum): Aura {
		$this->maximum = $maximum;
		return $this;
	}

	/**
	 * @param array (string=>mixed) &$data
	 * @throws UnserializeEntityException
	 */
	protected function validateSerializedData(array &$data): void {
		$this->validate($data, 'aura', 'int');
		$this->validate($data, 'maximum', 'int');
	}
}
