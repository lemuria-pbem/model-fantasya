<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use function Lemuria\getClass;
use Lemuria\Collectible;
use Lemuria\CollectibleTrait;
use Lemuria\Entity;
use Lemuria\Id;
use Lemuria\Lemuria;
use Lemuria\Model\Domain;
use Lemuria\Model\Exception\NotRegisteredException;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Serializable;

/**
 * An Unicum is an individual special item.
 */
class Unicum extends Entity implements Collectible
{
	protected final const COLLECTORS = [Unit::class, Construction::class, Vessel::class, Region::class];

	use BuilderTrait;
	use CollectibleTrait;

	private Composition $composition;

	/**
	 * @throws NotRegisteredException
	 */
	public static function get(Id $id): Unicum {
		/** @var Unicum $unicum */
		$unicum = Lemuria::Catalog()->get($id, Domain::UNICUM);
		return $unicum;
	}

	public function serialize(): array {
		$data                = parent::serialize();
		$data['composition'] = getClass($this->Composition());
		$data['properties']  = $this->Composition()->serialize();
		return $data;
	}

	public function unserialize(array $data): Serializable {
		parent::unserialize($data);
		$category = self::createComposition($data['composition']);
		$category->unserialize($data['properties']);
		$this->setComposition($category);
		return $this;
	}

	public function Catalog(): Domain {
		return Domain::UNICUM;
	}

	public function Composition(): Composition {
		return $this->composition->reshape($this);
	}

	/**
	 * @noinspection PhpIncompatibleReturnTypeInspection
	 */
	public function Collector(): Construction|Region|Unit|Vessel {
		return $this->findCollector(self::COLLECTORS);
	}

	public function setComposition(Composition $composition): Unicum {
		$this->composition = $composition->register($this);
		return $this;
	}

	public function replaceId(Id $id): Unicum {
		$this->composition->reshape($this);
		$oldId = $this->Id();
		$this->setId($id);
		$this->composition->register($this);
		$this->Collector()->Treasury()->replace($oldId, $id);
		return $this;
	}

	/**
	 * @param array (string=>mixed) $data
	 */
	protected function validateSerializedData(array &$data): void {
		parent::validateSerializedData($data);
		$this->validate($data, 'composition', 'string');
		$this->validate($data, 'properties', 'array');
	}
}
