<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Composition;

use Lemuria\Model\Fantasya\Commodity\Silver;
use Lemuria\Model\Fantasya\HerbalBook;
use Lemuria\Model\Fantasya\Ownable;
use Lemuria\Model\Fantasya\Readable;
use Lemuria\Model\Fantasya\Talent\Herballore;
use Lemuria\Model\Fantasya\Unicum;

class HerbAlmanac extends AbstractComposition implements Ownable, Readable
{
	private const int SILVER = 30;

	private const int WEIGHT = 5;

	protected int $level = Herballore::EXPLORE_LEVEL;

	protected HerbalBook $herbalBook;

	public function __construct() {
		$this->herbalBook = new HerbalBook();
	}

	public function HerbalBook(): HerbalBook {
		return $this->herbalBook;
	}

	public function Weight(): int {
		return self::WEIGHT;
	}

	public function init(): static {
		$this->herbalBook->clear();
		return parent::init();
	}

	public function serialize(): array {
		return $this->herbalBook->serialize();
	}

	public function unserialize(array $data): static {
		$this->herbalBook->unserialize($data);
		return $this;
	}

	public function register(Unicum $tenant): static {
		$this->property($tenant)->herbalBook = $this->herbalBook->getClone();
		return $this;
	}

	public function reshape(Unicum $tenant): static {
		$this->herbalBook = $this->property($tenant)->herbalBook;
		return $this;
	}

	protected function material(): array {
		return [Silver::class => self::SILVER];
	}

	protected function talent(): string {
		return Herballore::class;
	}
}
