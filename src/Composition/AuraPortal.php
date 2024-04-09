<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Composition;

use Lemuria\Model\Fantasya\Talent\Magic;
use Lemuria\Model\Fantasya\Practice;
use Lemuria\Model\Fantasya\Unicum;

class AuraPortal extends AbstractComposition
{
	protected const int WEIGHT = 2200 * 100;

	public function Weight(): int {
		return self::WEIGHT;
	}

	public function serialize(): array {
		return [];
	}

	public function unserialize(array $data): static {
		return $this;
	}

	public function supports(Practice $action): bool {
		return match($action) {
			Practice::Apply, Practice::Destroy, Practice::Read => true,
			default                                            => false
		};
	}

	public function register(Unicum $tenant): static {
		return $this;
	}

	public function reshape(Unicum $tenant): static {
		return $this;
	}

	protected function material(): array {
		return [];
	}

	protected function talent(): string {
		return Magic::class;
	}
}
