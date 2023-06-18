<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Collectible;
use Lemuria\CollectibleTrait;
use Lemuria\Collector;
use Lemuria\CollectorTrait;
use Lemuria\Entity;
use Lemuria\Id;
use Lemuria\Lemuria;
use Lemuria\Model\Domain;
use Lemuria\Model\Exception\NotRegisteredException;
use Lemuria\Serializable;
use Lemuria\Validate;

/**
 * A realm is an area of regions that are managed centrally.
 */
class Realm extends Entity implements Collectible, Collector
{
	use CollectibleTrait;
	use CollectorTrait;

	private const IDENTIFIER = 'identifier';

	private const TERRITORY = 'territory';

	private Id $identifier;

	private readonly Territory $territory;

	/**
	 * @return array<Realm>
	 */
	public static function all(): array {
		return Lemuria::Catalog()->getAll(Domain::Realm);
	}

	/**
	 * Get a Realm.
	 *
	 * @throws NotRegisteredException
	 */
	public static function get(Id $id): self {
		/** @var Realm $realm */
		$realm = Lemuria::Catalog()->get($id, Domain::Realm);
		return $realm;
	}

	/**
	 * Create an empty realm.
	 */
	public function __construct() {
		$this->territory = new Territory($this);
	}

	public function Catalog(): Domain {
		return Domain::Realm;
	}

	public function Identifier(): Id {
		return $this->identifier;
	}

	public function Party(): Party {
		/** @var Party $party */
		$party = $this->getCollector(__FUNCTION__);
		return $party;
	}

	public function Territory(): Territory {
		return $this->territory;
	}

	/**
	 * Get a plain data array of the model's data.
	 *
	 * @return array
	 */
	public function serialize(): array {
		$data                   = parent::serialize();
		$data[self::IDENTIFIER] = $this->identifier->Id();
		$data[self::TERRITORY]  = $this->territory->serialize();
		return $data;
	}

	/**
	 * Restore the model's data from serialized data.
	 */
	public function unserialize(array $data): Serializable {
		parent::unserialize($data);
		$this->identifier = new Id($data[self::IDENTIFIER]);
		$this->territory->unserialize($data[self::TERRITORY]);
		return $this;
	}

	/**
	 * This method will be called by the Catalog after loading is finished; the Collector can initialize its collections
	 * then.
	 */
	public function collectAll(): Collector {
		$this->territory->addCollectorsToAll();
		return $this;
	}

	public function setIdentifier(Id $identifier): Realm {
		$this->identifier = $identifier;
		return $this;
	}

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array $data): void {
		parent::validateSerializedData($data);
		$this->validate($data, self::IDENTIFIER, Validate::Int);
		$this->validate($data, self::TERRITORY, Validate::Array);
	}
}
