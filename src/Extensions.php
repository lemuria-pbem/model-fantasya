<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use function Lemuria\getClass;
use Lemuria\Model\Fantasya\Exception\ExtensionNotFoundException;
use Lemuria\Serializable;

class Extensions implements \ArrayAccess, Serializable
{
	protected const NAMESPACE = 'Lemuria\\Model\\Fantasya\\Extension\\';

	/**
	 * @var array<string, Extension>
	 */
	protected array $extensions = [];

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
			$data[$class] = $extension->serialize();
		}
		return $data;
	}

	/**
	 * Restore the model's data from serialized data.
	 */
	public function unserialize(array $data): Serializable {
		foreach ($data as $class => $extension) {
			$this->data[$class] = $this->createExtension($class)->unserialize($extension);
		}
		return $this;
	}

	public function add(Extension $extension): Extensions {
		$this->offsetSet($extension, $extension);
		return $this;
	}

	public function clear(): Extensions {
		$this->extensions = [];
		return $this;
	}

	protected function createExtension(string $class): Extension {
		$class = self::NAMESPACE . $class;
		return new $class();
	}
}
