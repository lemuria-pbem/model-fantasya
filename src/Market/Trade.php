<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Market;

use Lemuria\Collectible;
use Lemuria\CollectibleTrait;
use Lemuria\Id;
use Lemuria\Identifiable;
use Lemuria\IdentifiableTrait;
use Lemuria\Lemuria;
use Lemuria\Model\Domain;
use Lemuria\Model\Exception\NotRegisteredException;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Unit;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;
use Lemuria\Validate;

class Trade implements \Stringable, Collectible, Identifiable, Serializable
{
	public final const false DEMAND = false;

	public final const true OFFER = true;

	private const string ID = 'id';

	private const string IS_OFFER = 'isOffer';

	private const string IS_REPEAT = 'isRepeat';

	private const string GOODS = 'goods';

	private const string PRICE = 'price';

	use BuilderTrait;
	use CollectibleTrait;
	use IdentifiableTrait;
	use SerializableTrait;

	private bool $trade;

	private bool $isRepeat = false;

	private Deal $goods;

	private Deal $price;

	/**
	 * @return array<Trade>
	 */
	public static function all(): array {
		return Lemuria::Catalog()->getAll(Domain::Trade);
	}

	/**
	 * @throws NotRegisteredException
	 */
	public static function get(Id $id): self {
		/** @var Trade $trade */
		$trade = Lemuria::Catalog()->get($id, Domain::Trade);
		return $trade;
	}

	public function __construct(bool $init = false) {
		if ($init) {
			$this->goods = new Deal();
			$this->price = new Deal();
		}
	}

	public function Catalog(): Domain {
		return Domain::Trade;
	}

	public function Trade(): bool {
		return $this->trade;
	}

	public function IsRepeat(): bool {
		return $this->isRepeat;
	}

	public function IsSatisfiable(): bool {
		$inventory = $this->Unit()->Inventory();
		$deal      = $this->trade === self::OFFER ? $this->goods : $this->price;
		$commodity = $deal->Commodity();
		$reserve   = $inventory[$commodity];
		if ($this->goods->IsAdapting()) {
			if ($this->trade === self::OFFER) {
				$amount = 1;
			} else {
				$amount = $this->price->Maximum();
			}
		} else {
			if ($this->trade === self::OFFER) {
				$amount = $this->goods->Maximum();
			} else {
				$amount = $this->goods->IsVariable() ? $this->goods->Maximum() * $this->price->Maximum() : $this->price->Maximum();
			}
		}
		return $reserve->Count() >= $amount;
	}

	public function Goods(): Deal {
		return $this->goods;
	}

	public function Price(): Deal {
		return $this->price;
	}

	public function Unit(): Unit {
		/** @var Unit $unit */
		$unit = $this->getCollector(__FUNCTION__);
		return $unit;
	}

	public function __toString(): string {
		return ($this->trade === self::OFFER ? 'Offer' : 'Demand') . ' ' . $this->Id();
	}

	public function serialize(): array {
		$goods = $this->goods->serialize();
		$price = $this->price->serialize();
		$data  = [
			self::ID        => $this->Id()->Id(),
			self::IS_OFFER  => $this->trade,
			self::IS_REPEAT => $this->isRepeat,
			self::GOODS     => $goods[0],
			self::PRICE     => $price[0]];
		return $data;
	}

	public function unserialize(array $data): static {
		$this->validateSerializedData($data);
		$this->setId(new Id(($data[self::ID])));
		$this->trade    = $data[self::IS_OFFER];
		$this->isRepeat = $data[self::IS_REPEAT];
		$this->goods->unserialize([$data[self::GOODS]]);
		$this->price->unserialize([$data[self::PRICE]]);
		return $this;
	}

	public function setTrade(bool $isOffer): static {
		$this->trade = $isOffer;
		return $this;
	}

	public function setIsRepeat(bool $isRepeat): static {
		$this->isRepeat = $isRepeat;
		return $this;
	}

	public function setGoods(Deal $goods): static {
		$this->goods = $goods;
		return $this;
	}

	public function setPrice(Deal $price): static {
		$this->price = $price;
		return $this;
	}

	/**
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array $data): void {
		$this->validate($data, self::ID, Validate::Int);
		$this->validate($data, self::IS_OFFER, Validate::Bool);
		$this->validate($data, self::IS_REPEAT, Validate::Bool);
		$this->validate($data, self::GOODS, Validate::String);
		$this->validate($data, self::PRICE, Validate::String);
	}
}
