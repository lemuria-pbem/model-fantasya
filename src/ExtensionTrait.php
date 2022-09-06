<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

trait ExtensionTrait
{
	private readonly Extensions $extensions;

	public function Extensions(): Extensions {
		return $this->extensions;
	}

	private function initExtensions(): void {
		$this->extensions = new Extensions();
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
