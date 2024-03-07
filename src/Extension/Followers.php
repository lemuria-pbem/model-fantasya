<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Extension;

use Lemuria\Id;
use Lemuria\Identifiable;
use Lemuria\Lemuria;
use Lemuria\Model\Domain;
use Lemuria\Model\Fantasya\Extension;
use Lemuria\Model\Fantasya\People;
use Lemuria\Model\Reassignment;
use Lemuria\SerializableTrait;
use Lemuria\Validate;

/**
 * Follower are other units that stay on their master's side.
 */
class Followers implements Extension, Reassignment
{
	use ExtensionTrait;
	use SerializableTrait;

	protected final const string FOLLOWERS = 'followers';

	protected People $followers;

	public function __construct() {
		$this->followers = new People();
		Lemuria::Catalog()->addReassignment($this);
	}

	public function Followers(): People {
		return $this->followers;
	}

	public function serialize(): array {
		return [self::FOLLOWERS => $this->followers->serialize()];
	}

	public function unserialize(array $data): static {
		$this->followers->unserialize($data[self::FOLLOWERS]);
		return $this;
	}

	public function reassign(Id $oldId, Identifiable $identifiable): void {
		if ($identifiable->Catalog() === Domain::Unit && $this->followers->has($oldId)) {
			$this->followers->replace($oldId, $identifiable->Id());
		}
	}

	public function remove(Identifiable $identifiable): void {
		if ($identifiable->Catalog() === Domain::Unit && $this->followers->has($identifiable->Id())) {
			$this->followers->offsetUnset($identifiable->Id());
		}
	}

	protected function validateSerializedData(array $data): void {
		$this->validate($data, self::FOLLOWERS, Validate::Array);
	}
}
