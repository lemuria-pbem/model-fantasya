<?php
declare(strict_types = 1);
namespace Lemuria\Model\Lemuria\Storage;

use JetBrains\PhpStorm\Pure;

use Lemuria\Exception\DirectoryNotFoundException;
use Lemuria\Exception\FileException;
use Lemuria\Model\Exception\JsonException;
use Lemuria\Storage\FileProvider;

class JsonProvider
{
	public const DEFAULT = FileProvider::DEFAULT;

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
	 * @throws FileException
	 * @throws JsonException
	 */
	public function write(string $fileName, array $data): void {
		$this->provider->write($fileName, Json::encode($data));
	}
}
