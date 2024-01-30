<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

use function Lemuria\getClass;
use Lemuria\Assignable;
use Lemuria\Collector;
use Lemuria\CollectorTrait;
use Lemuria\Engine\Newcomer;
use Lemuria\Entity;
use Lemuria\Exception\LemuriaException;
use Lemuria\Id;
use Lemuria\Lemuria;
use Lemuria\Model\Domain;
use Lemuria\Model\Exception\NotRegisteredException;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Party\Presettings;
use Lemuria\Model\Fantasya\Party\Type;
use Lemuria\Validate;

/**
 * A party is the representation of a Lemuria player.
 */
class Party extends Entity implements Assignable, Collector
{
	use BuilderTrait;
	use CollectorTrait;
	use ExtensionTrait;

	private const string TYPE = 'type';

	private const string BANNER = 'banner';

	private const string UUID = 'uuid';

	private const string CREATION = 'creation';

	private const string ROUND = 'round';

	private const string RETIREMENT = 'retirement';

	private const string ORIGIN = 'origin';

	private const string RACE = 'race';

	private const string DIPLOMACY = 'diplomacy';

	private const string PEOPLE = 'people';

	private const string CHRONICLE = 'chronicle';

	private const string HERBAL_BOOK = 'herbalBook';

	private const string SPELL_BOOK = 'spellBook';

	private const string LOOT = 'loot';

	private const string PRESETTINGS = 'presettings';

	private const string POSSESSIONS = 'possessions';

	private const string REGULATION = 'regulation';

	private string $banner;

	private Id $origin;

	private Race $race;

	private readonly People $people;

	private readonly Chronicle $chronicle;

	private readonly Diplomacy $diplomacy;

	private readonly HerbalBook $herbalBook;

	private readonly SpellBook $spellBook;

	private readonly Loot $loot;

	private readonly Presettings $presettings;

	private readonly Possessions $possessions;

	private readonly Regulation $regulation;

	private ?array $serializedDiplomacy = null;

	private ?array $serializedHerbalBook = null;

	private ?array $serializedSpellBook = null;

	private ?array $serializedLoot = null;

	private UuidInterface $uuid;

	private int $creation;

	private int $round;

	private ?int $retirement = null;

	/**
	 * @return array<Party>
	 */
	public static function all(): array {
		return Lemuria::Catalog()->getAll(Domain::Party);
	}

	/**
	 * Get a Party.
	 *
	 * @throws NotRegisteredException
	 */
	public static function get(Id $id): self {
		/** @var Party $party */
		$party = Lemuria::Catalog()->get($id, Domain::Party);
		return $party;
	}

	/**
	 * Create an empty party.
	 */
	public function __construct(?Newcomer $newcomer = null, private Type $type = Type::Player) {
		$this->banner      = '';
		$this->uuid        = $newcomer ? Uuid::fromString($newcomer->Uuid()) : Uuid::uuid4();
		$this->creation    = $newcomer?->Creation() ?? time();
		$this->round       = Lemuria::Calendar()->Round();
		$this->people      = new People($this);
		$this->chronicle   = new Chronicle();
		$this->diplomacy   = new Diplomacy($this);
		$this->herbalBook  = new HerbalBook();
		$this->spellBook   = new SpellBook();
		$this->loot        = new Loot();
		$this->presettings = new Presettings();
		$this->possessions = new Possessions($this);
		$this->regulation  = new Regulation();
		$this->initExtensions($this);
	}

	/**
	 * Get the catalog domain.
	 */
	public function Catalog(): Domain {
		return Domain::Party;
	}

	public function Type(): Type {
		return $this->type;
	}

	public function Banner(): string {
		return $this->banner;
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

	public function Retirement(): ?int {
		return $this->retirement;
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
	public function Race(): Race {
		return $this->race;
	}

	/**
	 * Get all units.
	 */
	public function People(): People {
		return $this->people;
	}

	/**
	 * Get the chronicle.
	 */

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

	public function HerbalBook(): HerbalBook {
		if (is_array($this->serializedHerbalBook)) {
			$this->herbalBook->clear()->unserialize($this->serializedHerbalBook);
			$this->serializedHerbalBook = null;
		}
		return $this->herbalBook;
	}

	public function SpellBook(): SpellBook {
		if (is_array($this->serializedSpellBook)) {
			$this->spellBook->clear()->unserialize($this->serializedSpellBook);
			$this->serializedSpellBook = null;
		}
		return $this->spellBook;
	}

	public function Loot(): Loot {
		if (is_array($this->serializedLoot)) {
			$this->loot->unserialize($this->serializedLoot);
			$this->serializedLoot = null;
		}
		return $this->loot;
	}

	public function Presettings(): Presettings {
		return $this->presettings;
	}

	public function Possessions(): Possessions {
		return $this->possessions;
	}

	public function Regulation(): Regulation {
		return $this->regulation;
	}

	/**
	 * Get a plain data array of the model's data.
	 *
	 * @return array
	 */
	public function serialize(): array {
		$data                     = parent::serialize();
		$data[self::TYPE]         = $this->type;
		$data[self::BANNER]       = $this->banner;
		$data[self::UUID]         = $this->Uuid();
		$data[self::CREATION]     = $this->creation;
		$data[self::ROUND]        = $this->round;
		$data[self::RETIREMENT]   = $this->retirement;
		$data[self::ORIGIN]       = $this->origin->Id();
		$data[self::RACE]         = getClass($this->Race());
		$data[self::DIPLOMACY]    = $this->Diplomacy()->serialize();
		$data[self::PEOPLE]       = $this->People()->serialize();
		$data[self::CHRONICLE]    = $this->Chronicle()->serialize();
		$data[self::HERBAL_BOOK]  = $this->HerbalBook()->serialize();
		$data[self::SPELL_BOOK]   = $this->SpellBook()->serialize();
		$data[self::LOOT]         = $this->Loot()->serialize();
		$data[self::PRESETTINGS]  = $this->Presettings()->serialize();
		$data[self::POSSESSIONS]  = $this->Possessions()->serialize();
		$data[self::REGULATION]   = $this->Regulation()->serialize();
		return $data;
	}

	/**
	 * Restore the model's data from serialized data.
	 */
	public function unserialize(array $data): static {
		parent::unserialize($data);
		$this->type       = Type::from($data[self::TYPE]);
		$this->banner     = $data[self::BANNER];
		$this->uuid       = Uuid::fromString($data[self::UUID]);
		$this->creation   = $data[self::CREATION];
		$this->round      = $data[self::ROUND];
		$this->retirement = $data[self::RETIREMENT];
		$this->origin     = new Id($data[self::ORIGIN]);
		$this->setRace(self::createRace($data[self::RACE]));
		$this->People()->unserialize($data[self::PEOPLE]);
		$this->Chronicle()->unserialize($data[self::CHRONICLE]);
		$this->Presettings()->unserialize($data[self::PRESETTINGS]);
		$this->Possessions()->unserialize($data[self::POSSESSIONS]);
		$this->Regulation()->unserialize($data[self::REGULATION]);
		$this->serializedDiplomacy  = $data[self::DIPLOMACY];
		$this->serializedHerbalBook = $data[self::HERBAL_BOOK];
		$this->serializedSpellBook  = $data[self::SPELL_BOOK];
		$this->serializedLoot       = $data[self::LOOT];
		return $this;
	}

	/**
	 * This method will be called by the Catalog after loading is finished; the Collector can initialize its collections
	 * then.
	 */
	public function collectAll(): static {
		$this->People()->addCollectorsToAll();
		$this->Possessions()->addCollectorsToAll();
		return $this;
	}

	public function hasRetired(): bool {
		return $this->retirement !== null;
	}

	public function setBanner(string $banner): static {
		$this->banner = $banner;
		return $this;
	}

	public function setOrigin(Region $origin): static {
		$this->origin = $origin->Id();
		return $this;
	}

	public function setRace(Race $race): static {
		$this->race = $race;
		return $this;
	}

	public function retire(): static {
		if ($this->People()->count() > 0) {
			throw new LemuriaException('A party that has units cannot be retired.');
		}
		$this->retirement = Lemuria::Calendar()->Round();
		return $this;
	}

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array $data): void {
		parent::validateSerializedData($data);
		$this->validate($data, self::TYPE, Validate::Int);
		$this->validate($data, self::BANNER, Validate::String);
		$this->validate($data, self::UUID, Validate::String);
		$this->validate($data, self::CREATION, Validate::Int);
		$this->validate($data, self::ROUND, Validate::Int);
		$this->validate($data, self::RETIREMENT, Validate::IntOrNull);
		$this->validate($data, self::ORIGIN, Validate::Int);
		$this->validate($data, self::RACE, Validate::String);
		$this->validate($data, self::PEOPLE, Validate::Array);
		$this->validate($data, self::DIPLOMACY, Validate::Array);
		$this->validate($data, self::CHRONICLE, Validate::Array);
		$this->validate($data, self::HERBAL_BOOK, Validate::Array);
		$this->validate($data, self::SPELL_BOOK, Validate::Array);
		$this->validate($data, self::LOOT, Validate::Array);
		$this->validate($data, self::PRESETTINGS, Validate::Array);
		$this->validate($data, self::POSSESSIONS, Validate::Array);
		$this->validate($data, self::REGULATION, Validate::Array);
	}
}
