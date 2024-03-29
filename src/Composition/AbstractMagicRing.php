<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Composition;

use Lemuria\Model\Fantasya\Commodity\Jewelry\GoldRing;
use Lemuria\Model\Fantasya\MagicRing;
use Lemuria\Model\Fantasya\Ownable;
use Lemuria\Model\Fantasya\Practice;
use Lemuria\Model\Fantasya\Talent\Magic;
use Lemuria\Model\Fantasya\Unicum;

abstract class AbstractMagicRing extends AbstractComposition implements MagicRing, Ownable
{
	public function Weight(): int {
		return GoldRing::WEIGHT;
	}

	public function serialize(): array {
		return [];
	}

	public function unserialize(array $data): static {
		return $this;
	}

	public function supports(Practice $action): bool {
		return match($action) {
			Practice::Read, Practice::Write, Practice::Destroy => false,
			default                                            => true
		};
	}

	public function register(Unicum $tenant): static {
		return $this;
	}

	public function reshape(Unicum $tenant): static {
		return $this;
	}

	/**
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array $data): void {
	}

	protected function material(): array {
		return [GoldRing::class => 1];
	}

	protected function talent(): string {
		return Magic::class;
	}
}
