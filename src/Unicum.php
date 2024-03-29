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
use Lemuria\Validate;

/**
 * An Unicum is an individual special item.
 */
class Unicum extends Entity implements Collectible
{
	/**
	 * @type array<string>
	 */
	protected final const array COLLECTORS = [Unit::class, Construction::class, Vessel::class, Region::class];

	use BuilderTrait;
	use CollectibleTrait;

	private const string COMPOSITION = 'composition';

	private const string PROPERTIES = 'properties';

	private Composition $composition;

	/**
	 * @return array<Unicum>
	 */
	public static function all(): array {
		return Lemuria::Catalog()->getAll(Domain::Unicum);
	}

	/**
	 * @throws NotRegisteredException
	 */
	public static function get(Id $id): self {
		/** @var Unicum $unicum */
		$unicum = Lemuria::Catalog()->get($id, Domain::Unicum);
		return $unicum;
	}

	public function serialize(): array {
		$data                    = parent::serialize();
		$data[self::COMPOSITION] = getClass($this->Composition());
		$data[self::PROPERTIES]  = $this->Composition()->serialize();
		return $data;
	}

	public function unserialize(array $data): static {
		parent::unserialize($data);
		$category = self::createComposition($data[self::COMPOSITION]);
		$category->unserialize($data[self::PROPERTIES]);
		$this->setComposition($category);
		return $this;
	}

	public function Catalog(): Domain {
		return Domain::Unicum;
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

	public function setComposition(Composition $composition): static {
		$this->composition = $composition->register($this);
		return $this;
	}

	public function replaceId(Id $id): static {
		$this->composition->reshape($this);
		$oldId = $this->Id();
		$this->setId($id);
		$this->composition->register($this);
		$this->Collector()->Treasury()->replace($oldId, $id);
		return $this;
	}

	/**
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array $data): void {
		parent::validateSerializedData($data);
		$this->validate($data, self::COMPOSITION, Validate::String);
		$this->validate($data, self::PROPERTIES, Validate::Array);
	}
}
