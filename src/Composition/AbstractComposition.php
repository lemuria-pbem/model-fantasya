<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Composition;

use Lemuria\Model\Fantasya\ArtifactTrait;
use Lemuria\Model\Fantasya\CommodityTrait;
use Lemuria\Model\Fantasya\Composition;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Practice;
use Lemuria\Model\Fantasya\Requirement;
use Lemuria\SerializableTrait;
use Lemuria\SingletonSet;
use Lemuria\SingletonTrait;
use Lemuria\TenantTrait;

abstract class AbstractComposition implements Composition
{
	use ArtifactTrait;
	use BuilderTrait;
	use CommodityTrait;
	use SerializableTrait;
	use SingletonTrait;
	use TenantTrait;

	protected int $level = 1;

	public static function all(): SingletonSet {
		return self::getAll(__DIR__);
	}

	public function getCraft(): Requirement {
		return new Requirement(self::createTalent($this->talent()), $this->level);
	}

	public function supports(Practice $action): bool {
		return true;
	}

	abstract protected function talent(): string;
}
