<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use function Lemuria\getClass;
use Lemuria\Collector;
use Lemuria\Exception\LemuriaException;
use Lemuria\Model\Fantasya\Exception\ExtensionNotFoundException;
use Lemuria\Serializable;

class Extensions implements \ArrayAccess, Serializable
{
	protected const string NAMESPACE = 'Lemuria\\Model\\Fantasya\\Extension\\';

	/**
	 * @var array<string, Extension>
	 */
	protected array $extensions = [];

	public function __construct(private readonly ?Collector $collector = null) {
	}

	/**
	 * @param Extension|string $offset
	 */
	public function offsetExists(mixed $offset): bool {
		$class = getClass($offset);
		return isset($this->extensions[$class]);
	}

	/**
	 * @param Extension|string $offset
	 */
	public function offsetGet(mixed $offset): Extension {
		$class = getClass($offset);
		if (isset($this->extensions[$class])) {
			return $this->extensions[$class];
		}
		throw new ExtensionNotFoundException($offset);
	}

	/**
	 * @param Extension|string $offset
	 * @param Extension $value
	 */
	public function offsetSet(mixed $offset, mixed $value): void {
		$this->extensions[getClass($offset)] = $value;
	}

	/**
	 * @param Extension|string $offset
	 */
	public function offsetUnset(mixed $offset): void {
		$class = getClass($offset);
		unset($this->extensions[$class]);
	}

	/**
	 * Get a plain data array of the model's data.
	 */
	public function serialize(): array {
		$data = [];
		foreach ($this->extensions as $class => $extension) {
			$serializedExtension = $extension->serialize();
			if ($serializedExtension) {
				$data[$class] = $serializedExtension;
			}
		}
		return $data;
	}

	/**
	 * Restore the model's data from serialized data.
	 */
	public function unserialize(array $data): static {
		foreach ($data as $class => $extension) {
			$this->extensions[$class] = $this->createExtension($class)->unserialize($extension);
		}
		return $this;
	}

	public function init(Extension|string $extension, ?\Closure $constructor = null): Extension {
		$class = is_string($extension) ? $extension : $extension::class;
		$name  = getClass($class);
		if (isset($this->extensions[$name])) {
			return $this->extensions[$name];
		}
		$extension = $constructor ? $constructor() : new $class();
		if ($extension instanceof $class && $extension instanceof Extension) {
			$this->extensions[$name] = $extension;
			return $extension;
		}
		throw new LemuriaException('Extension class mismatch.');
	}

	public function add(Extension $extension): static {
		$this->offsetSet($extension, $extension);
		return $this;
	}

	public function clear(): Extensions {
		$this->extensions = [];
		return $this;
	}

	protected function createExtension(string $class): Extension {
		$class = self::NAMESPACE . $class;
		return new $class($this->collector);
	}
}
