<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Composition;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

use function Lemuria\getClass;
use Lemuria\Model\Fantasya\Commodity\Silver;
use Lemuria\Model\Fantasya\Spell;
use Lemuria\Model\Fantasya\Talent\Magic;
use Lemuria\Serializable;

class Scroll extends AbstractComposition
{
	private const SILVER = 10;

	private const WEIGHT = 3;

	protected ?Spell $spell = null;

	public function Spell(): ?Spell {
		return $this->spell;
	}

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	#[ArrayShape(['spell' => "string"])]
	#[Pure] public function serialize(): array {
		$data = ['spell' => $this->spell ? getClass($this->spell) : null];
		return $data;
	}

	public function unserialize(array $data): Serializable {
		$this->spell = $data['spell'];
		return $this;
	}

	public function setSpell(Spell $spell): Scroll {
		$this->spell = $spell;
		return $this;
	}

	/**
	 * @param array (string=>mixed) $data
	 */
	protected function validateSerializedData(array &$data): void {
		$this->validate($data, 'spell', '?string');
	}

	#[ArrayShape([Silver::class => "int"])]
	#[Pure] protected function material(): array {
		return [Silver::class => self::SILVER];
	}

	protected function talent(): string {
		return Magic::class;
	}
}
