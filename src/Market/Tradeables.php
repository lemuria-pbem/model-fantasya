<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Market;

use Lemuria\Exception\SingletonException;
use Lemuria\Model\Fantasya\Commodity;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;
use Lemuria\SingletonSet;

class Tradeables extends SingletonSet
{
	use SerializableTrait;

	private bool $isExclusion = false;

	public function IsExclusion(): bool {
		return $this->isExclusion;
	}

	public function serialize(): array {
		return ['iExclusion' => $this->isExclusion, 'goods' => parent::serialize()];
	}

	public function unserialize(array $data): Serializable {
		parent::unserialize($data['goods']);
		$this->isExclusion = $data['isExclusion'];
		return $this;
	}

	public function isAllowed(Commodity $commodity): bool {
		$isListed = $this->offsetExists($commodity);
		return $this->IsExclusion() ? !$isListed : $isListed;
	}

	public function setIsExclusion(bool $isExclusion): Tradeables {
		$this->isExclusion = $isExclusion;
		return $this;
	}

	public function allow(Commodity $commodity): Tradeables {
		if ($this->isExclusion) {
			$this->delete($commodity);
		} else {
			$this->add($commodity);
		}
		return $this;
	}

	public function ban(Commodity $commodity): Tradeables {
		if ($this->isExclusion) {
			$this->add($commodity);
		} else {
			$this->delete($commodity);
		}
		return $this;
	}

	protected function validateSingleton(mixed $singleton): void {
		if (!($singleton instanceof Commodity)) {
			throw new SingletonException($singleton, 'commodity');
		}
	}

	/**
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array $data): void {
		$this->validate($data, 'isExclusion', 'bool');
		$this->validate($data, 'goods', 'array');
	}
}
