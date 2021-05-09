<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Herb;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Herb;
use Lemuria\Model\Fantasya\RawMaterialTrait;
use Lemuria\Model\Fantasya\Talent\Herballore;
use Lemuria\SingletonTrait;

abstract class AbstractHerb implements Herb
{
	use RawMaterialTrait;
	use SingletonTrait;

	private const WEIGHT = 1;

	private string $craft = Herballore::class;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}
}
