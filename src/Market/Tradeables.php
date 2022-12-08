<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Market;

use Lemuria\Exception\SingletonException;
use Lemuria\Model\Fantasya\Commodity;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;
use Lemuria\SingletonSet;
use Lemuria\Validate;

class Tradeables extends SingletonSet
{
	use SerializableTrait;

	private const IS_EXCLUSION = 'isExclusion';

	private const GOODS = 'goods';

	private bool $isExclusion = true;

	public function IsExclusion(): bool {
		return $this->isExclusion;
	}

	public function serialize(): array {
		return [self::IS_EXCLUSION => $this->isExclusion, self::GOODS => parent::serialize()];
	}

	public function unserialize(array $data): Serializable {
		parent::unserialize($data[self::GOODS]);
		$this->isExclusion = $data[self::IS_EXCLUSION];
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
		$this->validate($data, self::IS_EXCLUSION, Validate::Bool);
		$this->validate($data, self::GOODS, Validate::Array);
	}
}
