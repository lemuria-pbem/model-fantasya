<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

use function Lemuria\getClass;
use Lemuria\Assignable;
use Lemuria\Collector;
use Lemuria\CollectorTrait;
use Lemuria\Entity;
use Lemuria\Id;
use Lemuria\Lemuria;
use Lemuria\Model\Catalog;
use Lemuria\Model\Exception\NotRegisteredException;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Serializable;

/**
 * A party is the representation of a Lemuria player.
 */
class Party extends Entity implements Assignable, Collector
{
	use BuilderTrait;
	use CollectorTrait;

	private Id $origin;

	private Race $race;

	private People $people;

	private Chronicle $chronicle;

	private Diplomacy $diplomacy;

	private ?array $serializedDiplomacy = null;

	private UuidInterface $uuid;

	private int $creation;

	private int $round;

	/**
	 * Get a Party.
	 *
	 * @throws NotRegisteredException
	 */
	public static function get(Id $id): self {
		/* @var Party $party */
		$party = Lemuria::Catalog()->get($id, Catalog::PARTIES);
		return $party;
	}

	/**
	 * Create an empty party.
	 */
	public function __construct(?string $uuid = null) {
		$this->uuid      = $uuid ?? Uuid::uuid4();
		$this->creation  = time();
		$this->round     = Lemuria::Calendar()->Round();
		$this->people    = new People($this);
		$this->chronicle = new Chronicle();
		$this->diplomacy = new Diplomacy($this);
	}

	/**
	 * Get a plain data array of the model's data.
	 *
	 * @return array
	 */
	#[ArrayShape([
		'id' => 'int', 'name' => 'string', 'description' => 'string', 'people' => 'int[]', 'diplomacy' => 'array',
		'race' => 'string', 'origin' => 'int', 'uuid' => 'string', 'round' => 'int', 'creation' => 'int'
	])]
	public function serialize(): array {
		$data              = parent::serialize();
		$data['uuid']      = $this->Uuid();
		$data['creation']  = $this->creation;
		$data['round']     = $this->round;
		$data['origin']    = $this->origin->Id();
		$data['race']      = getClass($this->Race());
		$data['diplomacy'] = $this->Diplomacy()->serialize();
		$data['people']    = $this->People()->serialize();
		$data['chronicle'] = $this->Chronicle()->serialize();
		return $data;
	}

	/**
	 * Restore the model's data from serialized data.
	 */
	public function unserialize(array $data): Serializable {
		parent::unserialize($data);
		$this->uuid     = Uuid::fromString($data['uuid']);
		$this->creation = $data['creation'];
		$this->round    = $data['round'];
		$this->origin   = new Id($data['origin']);
		$this->setRace(self::createRace($data['race']));
		$this->People()->unserialize($data['people']);
		$this->Chronicle()->unserialize($data['chronicle']);
		$this->serializedDiplomacy = $data['diplomacy'];
		return $this;
	}

	/**
	 * Get the catalog namespace.
	 */
	#[Pure] public function Catalog(): int {
		return Catalog::PARTIES;
	}

	/**
	 * This method will be called by the Catalog after loading is finished; the Collector can initialize its collections
	 * then.
	 */
	public function collectAll(): Collector {
		$this->People()->addCollectorsToAll();
		return $this;
	}

	public function Uuid(): string {
		return $this->uuid->toString();
	}

	public function Creation(): int {
		return $this->creation;
	}

	public function Round(): int {
		return $this->round;
	}

	/**
	 * Get the region in Lemuria where the party came into play.
	 */
	public function Origin(): Region {
		return Region::get($this->origin);
	}

	/**
	 * Get the party's race.
	 */
	#[Pure] public function Race(): Race {
		return $this->race;
	}

	/**
	 * Get all units.
	 */
	#[Pure] public function People(): People {
		return $this->people;
	}

	/**
	 * Get the chronicle.
	 */
	#[Pure]
	public function Chronicle(): Chronicle {
		return $this->chronicle;
	}

	/**
	 * Get all diplomatic relations.
	 */
	public function Diplomacy(): Diplomacy {
		if (is_array($this->serializedDiplomacy)) {
			$this->diplomacy->clear()->unserialize($this->serializedDiplomacy);
			$this->serializedDiplomacy = null;
		}
		return $this->diplomacy;
	}

	/**
	 * Set the region in Lemuria where the party came into play.
	 */
	public function setOrigin(Region $origin): Party {
		$this->origin = $origin->Id();
		return $this;
	}

	/**
	 * Set the party's race.
	 */
	public function setRace(Race $race): Party {
		$this->race = $race;
		return $this;
	}

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array(string=>mixed) $data
	 */
	protected function validateSerializedData(array &$data): void {
		parent::validateSerializedData($data);
		$this->validate($data, 'uuid', 'string');
		$this->validate($data, 'creation', 'int');
		$this->validate($data, 'round', 'int');
		$this->validate($data, 'origin', 'int');
		$this->validate($data, 'race', 'string');
		$this->validate($data, 'people', 'array');
		$this->validate($data, 'diplomacy', 'array');
		$this->validate($data, 'chronicle', 'array');
	}
}
