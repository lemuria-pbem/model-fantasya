<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Collector;
use Lemuria\Validate;

trait ExtensionTrait
{
	private const string EXTENSIONS = 'extensions';

	private readonly Extensions $extensions;

	public function Extensions(): Extensions {
		return $this->extensions;
	}

	private function initExtensions(?Collector $collector = null): void {
		$this->extensions = new Extensions($collector);
	}

	private function serializeExtensions(array &$data): void {
		$data[self::EXTENSIONS] = $this->extensions->serialize();
	}

	private function unserializeExtensions(array $data): void {
		$this->extensions->unserialize($data[self::EXTENSIONS]);
	}

	private function validateExtensions(array $data): void {
		$this->validate($data, self::EXTENSIONS, Validate::Array);
	}
}
