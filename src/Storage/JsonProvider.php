<?php
declare(strict_types = 1);
namespace Lemuria\Model\Lemuria\Storage;

use JetBrains\PhpStorm\Pure;

use Lemuria\Exception\DirectoryNotFoundException;
use Lemuria\Exception\FileException;
use Lemuria\Exception\LemuriaException;
use Lemuria\Model\Lemuria\Exception\JsonException;
use Lemuria\Storage\FileProvider;
use Lemuria\Storage\Provider;

class JsonProvider implements Provider
{
	private FileProvider $provider;

	#[Pure]
	public function __construct(string $directory) {
		$this->provider = new FileProvider($directory);
	}

	/**
	 * @throws DirectoryNotFoundException
	 */
	public function exists(string $fileName): bool {
		return $this->provider->exists($fileName);
	}

	/**
	 * @throws FileException
	 * @throws JsonException
	 */
	public function read(string $fileName): array {
		return Json::decode($this->provider->read($fileName));
	}

	/**
	 * @param array $data
	 * @throws FileException
	 * @throws JsonException
	 */
	public function write(string $fileName, mixed $data): void {
		if (!is_array($data)) {
			throw new LemuriaException('JsonProvider needs an arrax.');
		}
		$this->provider->write($fileName, Json::encode($data));
	}
}
