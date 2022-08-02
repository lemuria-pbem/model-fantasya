<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Storage\Migration;

use function Lemuria\getClass;
use Lemuria\Exception\LemuriaException;
use Lemuria\Serializable;

abstract class AbstractModel
{
	/**
	 * @var array(string=>mixed)
	 */
	protected array $default = [];

	public function getDefault(string $key): mixed {
		if (array_key_exists($key, $this->default)) {
			return $this->default[$key];
		}
		throw new LemuriaException('Invalid key for ' . getClass($this) . ' model: ' . $key);
	}

	/**
	 * @param array<string, mixed> $data
	 * @return array(int=>string)
	 */
	public function getMissing(array $data): array {
		$missing = [];
		$i       = 0;
		foreach (array_keys($this->default) as $key) {
			if (!array_key_exists($key, $data)) {
				$missing[$i] = $key;
			}
			$i++;
		}
		return $missing;
	}

	protected function addBool(string $key, ?bool $default = false): void {
		$this->default[$key] = $default;
	}

	protected function addInteger(string $key, ?int $default = 0): void {
		$this->default[$key] = $default;
	}

	protected function addFloat(string $key, ?float $default = 0.0): void {
		$this->default[$key] = $default;
	}

	protected function addString(string $key, ?string $default = ''): void {
		$this->default[$key] = $default;
	}

	protected function addArray(string $key, ?array $default = []): void {
		$this->default[$key] = $default;
	}

	protected function addSerializable(string $key, ?Serializable $default = null): void {
		$this->default[$key] = $default?->serialize();
	}
}
