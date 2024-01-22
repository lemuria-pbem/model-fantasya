<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Extension;

use Lemuria\EntitySet;
use Lemuria\Exception\LemuriaException;
use Lemuria\Exception\UnserializeEntityException;
use Lemuria\Exception\UnserializeException;
use Lemuria\Id;
use Lemuria\Model\Fantasya\Extension;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Market\Deal;
use Lemuria\Model\Fantasya\Unicum;
use Lemuria\SerializableTrait;
use Lemuria\Validate;

/**
 * Valuables of a unit are unicum offers.
 *
 * @method Unicum offsetGet(int|Id $offset)
 * @method Unicum current()
 */
class Valuables extends EntitySet implements Extension
{
	private const string UNICUM = 'unicum';

	private const string DEAL = 'deal';

	use BuilderTrait;
	use ExtensionTrait;
	use SerializableTrait;

	/**
	 * @var array<int, Deal>
	 */
	private array $deal = [];

	public function serialize(): array {
		$ids = parent::serialize();
		sort($ids);

		$deals = [];
		foreach ($this->deal as $id => $deal) {
			$deals[$id] = $deal->serialize();
		}
		ksort($deals);

		return [self::UNICUM => $ids, self::DEAL => array_values($deals)];
	}

	public function unserialize(array $data): static {
		$ids = $data[self::UNICUM];
		parent::unserialize($ids);
		$n = count($ids);

		$this->deal = [];
		$deals      = $data[self::DEAL];
		for ($i = 0; $i < $n; $i++) {
			$deal                 = new Deal();
			$this->deal[$ids[$i]] = $deal->unserialize($deals[$i]);
		}

		return $this;
	}

	public function clear(): static {
		parent::clear();
		$this->deal = [];
		return $this;
	}

	public function add(Unicum $unicum, Deal $price): static {
		$id = $unicum->Id();
		$this->addEntity($id);
		$this->deal[$id->Id()] = $price;
		return $this;
	}

	public function remove(Unicum $unicum): static {
		$id = $unicum->Id();
		$this->removeEntity($id);
		unset($this->deal[$id->Id()]);
		return $this;
	}

	public function getPrice(Unicum $unicum): Deal {
		$id = $unicum->Id()->Id();
		if (isset($this->deal[$id])) {
			return $this->deal[$id];
		}
		throw new LemuriaException('No price set for unicum ' . $unicum . '.');
	}

	/**
	 * @throws UnserializeEntityException
	 */
	protected function validateSerializedData(array $data): void {
		$this->validate($data, self::UNICUM, Validate::Array);
		$this->validate($data, self::DEAL, Validate::Array);
	}

	protected function get(Id $id): Unicum {
		return Unicum::get($id);
	}
}
