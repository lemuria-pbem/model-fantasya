<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\EntitySet;
use Lemuria\Exception\LemuriaException;
use Lemuria\Exception\UnserializeException;
use Lemuria\Id;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;
use Lemuria\Validate;

class Regulation extends Landmass
{
	use SerializableTrait;

	private const ENTITIES = 'entities';

	private const QUOTAS = 'quotas';

	/**
	 * @var array<int, Quotas>
	 */
	private array $quota = [];

	/**
	 * @return array<string, array>
	 */
	public function serialize(): array {
		$entities = [];
		$quotas   = [];
		foreach ($this->quota as $id => $quota) {
			$entities[] = $id;
			$quotas[]   = $quota->serialize();
		}
		return [self::ENTITIES => $entities, self::QUOTAS => $quotas];
	}

	/**
	 * @param array<string, array> $data
	 * @noinspection DuplicatedCode
	 */
	public function unserialize(array $data): Serializable {
		$this->validateSerializedData($data);
		if ($this->count() > 0) {
			$this->clear();
		}

		$entities = array_values($data[self::ENTITIES]);
		$quotas   = array_values($data[self::QUOTAS]);
		$n        = count($entities);
		if (count($quotas) !== $n) {
			throw new UnserializeException('Mismatch of ' . self::ENTITIES . ' and ' . self::QUOTAS . ' count.');
		}

		for ($i = 0; $i < $n; $i++) {
			$id = $entities[$i];
			$this->addEntity(new Id($id));
			$quota = new Quotas();
			$quota->unserialize($quotas[$i]);
			$this->quota[$id] = $quota;
		}
		return $this;
	}

	public function clear(): Regulation {
		$this->quota = [];
		return parent::clear();
	}

	/**
	 * @throws LemuriaException
	 */
	public function fill(EntitySet $set): Regulation {
		throw new LemuriaException('Not implemented.');
	}

	public function getQuotas(Region $region): ?Quotas {
		$id = $region->Id()->Id();
		return $this->quota[$id] ?? null;
	}

	protected function addEntity(Id $id): void {
		parent::addEntity($id);
		$id = $id->Id();
		if (!isset($this->quota[$id])) {
			$this->quota[$id] = new Quotas();
		}
	}

	protected function removeEntity(Id $id): void {
		parent::removeEntity($id);
		unset($this->quota[$id->Id()]);
	}

	/**
	 * @param array<string, array> $data
	 */
	protected function validateSerializedData(array $data): void {
		$this->validate($data, self::ENTITIES, Validate::Array);
		$this->validate($data, self::QUOTAS, Validate::Array);
	}
}
