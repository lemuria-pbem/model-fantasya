<?php
/** @noinspection PhpIdempotentOperationInspection */
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Composition;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Silver;
use Lemuria\Model\Fantasya\Composition;
use Lemuria\Model\Fantasya\Readable;
use Lemuria\Model\Fantasya\Talent\Magic;
use Lemuria\Model\Fantasya\Unicum;
use Lemuria\Serializable;
use Lemuria\SingletonSet;
use Lemuria\TenantTrait;

class Spellbook extends AbstractComposition implements Readable
{
	use TenantTrait;

	private const SILVER = 1000;

	private const WEIGHT = 1 * 100;

	protected SingletonSet $spells;

	#[Pure] public function __construct() {
		$this->spells = new SingletonSet();
	}

	public function Spells(): SingletonSet {
		return $this->spells;
	}

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	#[ArrayShape(['spells' => "string[]"])]
	#[Pure] public function serialize(): array {
		$data = ['spells' => $this->spells->serialize()];
		return $data;
	}

	public function unserialize(array $data): Serializable {
		$this->spells->unserialize($data['spells']);
		return $this;
	}

	public function register(Unicum $tenant): Composition {
		$this->property($tenant)->spells = $this->spells;
		return $this;
	}

	public function reshape(Unicum $tenant): Composition {
		$this->spells = $this->property($tenant)->spells;
		return $this;
	}

	/**
	 * @param array (string=>mixed) $data
	 */
	protected function validateSerializedData(array &$data): void {
		$this->validate($data, 'spells', 'array');
	}

	#[ArrayShape([Silver::class => "int"])]
	#[Pure] protected function material(): array {
		return [Silver::class => self::SILVER];
	}

	protected function talent(): string {
		return Magic::class;
	}
}
