<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Composition;

use Lemuria\Model\Fantasya\Commodity\Silver;
use Lemuria\Model\Fantasya\Ownable;
use Lemuria\Model\Fantasya\Readable;
use Lemuria\Model\Fantasya\Talent\Magic;
use Lemuria\Model\Fantasya\Unicum;
use Lemuria\SingletonSet;
use Lemuria\TenantTrait;
use Lemuria\Validate;

class Spellbook extends AbstractComposition implements Ownable, Readable
{
	use TenantTrait;

	private const string SPELLS = 'spells';

	private const int SILVER = 1000;

	private const int WEIGHT = 50;

	protected SingletonSet $spells;

	public function __construct() {
		$this->spells = new SingletonSet();
	}

	public function Spells(): SingletonSet {
		return $this->spells;
	}

	public function Weight(): int {
		return self::WEIGHT;
	}

	public function init(): static {
		$this->spells->clear();
		return parent::init();
	}

	public function serialize(): array {
		$data = [self::SPELLS => $this->spells->serialize()];
		return $data;
	}

	public function unserialize(array $data): static {
		$this->spells->unserialize($data[self::SPELLS]);
		return $this;
	}

	public function register(Unicum $tenant): static {
		$this->property($tenant)->spells = $this->spells;
		return $this;
	}

	public function reshape(Unicum $tenant): static {
		$this->spells = $this->property($tenant)->spells;
		return $this;
	}

	/**
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array $data): void {
		$this->validate($data, self::SPELLS, Validate::Array);
	}

	protected function material(): array {
		return [Silver::class => self::SILVER];
	}

	protected function talent(): string {
		return Magic::class;
	}
}
