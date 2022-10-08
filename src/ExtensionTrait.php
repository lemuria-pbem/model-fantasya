<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Collector;

trait ExtensionTrait
{
	private readonly Extensions $extensions;

	public function Extensions(): Extensions {
		return $this->extensions;
	}

	private function initExtensions(?Collector $collector = null): void {
		$this->extensions = new Extensions($collector);
	}

	private function serializeExtensions(array &$data): void {
		$data['extensions'] = $this->extensions->serialize();
	}

	private function unserializeExtensions(array $data): void {
		$this->extensions->unserialize($data['extensions']);
	}

	private function validateExtensions(array &$data): void {
		$this->validate($data, 'extensions', 'array');
	}
}
