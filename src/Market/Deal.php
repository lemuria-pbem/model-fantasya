<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Market;

use Lemuria\Exception\LemuriaException;
use Lemuria\Exception\UnserializeException;
use Lemuria\Model\Fantasya\Commodity;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;
use Lemuria\Validate;

class Deal implements \Stringable, Serializable
{
	use BuilderTrait;
	use SerializableTrait;

	public const int ADAPTING_MAX = PHP_INT_MAX;

	private array $parts;

	public function __construct(private ?Commodity $commodity = null, private int $amount = 1, private int $max = 0) {
	}

	public function __toString(): string {
		return $this->max > 0 ? $this->amount . '-' . $this->max . ' ' . $this->commodity : $this->amount . ' ' . $this->commodity;
	}

	public function IsVariable(): bool {
		return $this->max > 0;
	}

	public function IsAdapting(): bool {
		return $this->max === self::ADAPTING_MAX;
	}

	public function Commodity(): Commodity {
		return $this->commodity;
	}

	public function Amount(): int {
		return $this->amount;
	}

	public function Minimum(): int {
		return $this->amount;
	}

	public function Maximum(): int {
		return $this->max > 0 ? $this->max : $this->amount;
	}

	public function serialize(): array {
		return [$this->__toString()];
	}

	public function unserialize(array $data): static {
		$this->validateSerializedData($data);
		$this->commodity = self::createCommodity($this->parts[0]);
		$this->amount    = $this->parts[1];
		$this->max       = $this->parts[2];
		return $this;
	}

	/**
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array $data): void {
		$this->validate($data, 0, Validate::String);
		if (preg_match('/^(\d+)(?:-(\d+))? ([a-zA-Z]+)$/', $data[0], $matches) !== 1) {
			throw new UnserializeException('Deal has invalid format: ' . $data[0]);
		}
		$this->parts = match(count($matches)) {
			3 => [$matches[2], (int)$matches[1], 0],
			4 => [$matches[3], (int)$matches[1], (int)$matches[2]],
			default => throw new LemuriaException()
		};
	}
}
