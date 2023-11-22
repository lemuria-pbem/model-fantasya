<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Composition;

use function Lemuria\getClass;
use Lemuria\Model\Fantasya\Unicum;
use Lemuria\Model\Fantasya\Commodity\Silver;
use Lemuria\Model\Fantasya\Ownable;
use Lemuria\Model\Fantasya\Readable;
use Lemuria\Model\Fantasya\Spell;
use Lemuria\Model\Fantasya\Talent\Magic;
use Lemuria\Validate;

class Scroll extends AbstractComposition implements Ownable, Readable
{
	private const int SILVER = 10;

	private const int WEIGHT = 1;

	private const string SPELL = 'spell';

	protected ?Spell $spell = null;

	public function Spell(): ?Spell {
		return $this->spell;
	}

	public function Weight(): int {
		return self::WEIGHT;
	}

	public function init(): static {
		$this->spell = null;
		return parent::init();
	}

	public function serialize(): array {
		$data = [self::SPELL => $this->spell ? getClass($this->spell) : null];
		return $data;
	}

	public function unserialize(array $data): static {
		$spell = $data[self::SPELL];
		if ($spell) {
			$this->spell = self::createSpell($spell);
		}
		return $this;
	}

	public function register(Unicum $tenant): static {
		$this->property($tenant)->spell = $this->spell;
		return $this;
	}

	public function reshape(Unicum $tenant): static {
		$this->spell = $this->property($tenant)->spell;
		return $this;
	}

	public function setSpell(Spell $spell): Scroll {
		$this->spell = $spell;
		return $this;
	}

	/**
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array $data): void {
		$this->validate($data, self::SPELL, Validate::StringOrNull);
	}

	protected function material(): array {
		return [Silver::class => self::SILVER];
	}

	protected function talent(): string {
		return Magic::class;
	}
}
